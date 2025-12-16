<?php
session_start();
require 'dbnormal.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, surname, information FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_info = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT id, medicine, age, weight, dose, daily_amount, discomfort, sub_discomfort, guidance, created_at FROM Ills WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$illness_records = [];
while ($row = $result->fetch_assoc()) {
    $ill_id = $row['id'];
    $stmt2 = $conn->prepare("SELECT conclusion_rationale, result FROM medicine_results WHERE user_id = ? AND ill_id = ?");
    $stmt2->bind_param("ii", $user_id, $ill_id);
    $stmt2->execute();
    $res = $stmt2->get_result()->fetch_assoc();
    $row['conclusion_rationale'] = $res['conclusion_rationale'] ?? '';
    $row['result'] = $res['result'] ?? '';
    $illness_records[] = $row;
    $stmt2->close();
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Özgeçmişi</title>
    <link rel="shortcut icon" href="../images/doctor.ico">
    <link rel="stylesheet" href="resumestyle.css">
</head>
<body>

<div class="header">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/logout" class="button logout">Çıkış</a>
        <a href="/" class="button restart">Web Doktor</a>
        <a href="/resume" class="button resume">Yenile</a>
    <?php else: ?>
        <a href="/login" class="button logout">Giriş</a>
    <?php endif; ?>
</div>

<h2>Kullanıcı Bilgileri</h2>

<table class="header-table">
    <tr><td><strong>Ad</strong></td><td><?= htmlspecialchars($user_info['name'] ?? '') ?></td></tr>
    <tr><td><strong>Soyad</strong></td><td><?= htmlspecialchars($user_info['surname'] ?? '') ?></td></tr>
    <tr><td><strong>Özel Rahatsızlık Bilgisi</strong></td><td><?= trim($user_info['information'] ?? '') === "" ? "Herhangi bir özel rahatsızlığı olmadığı bildirilmiştir." : htmlspecialchars($user_info['information']) ?></td></tr>
</table>

<h2>Geçmiş Kayıtlar</h2>

<?php if (empty($illness_records)): ?>
    <div class="no-records">Kayıt bulunamadı.</div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Tarih</th>
                <th>İlaç</th>
                <th>Yaş</th>
                <th>Ağırlık</th>
                <th>Doz</th>
                <th>Günlük Miktar</th>
                <th>Rahatsızlık</th>
                <th>Alt Rahatsızlık</th>
                <th>Rehberlik</th>
                <th>Gerekçe</th>
                <th>Sonuç</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($illness_records as $record): 
                $status = ($record['result'] === '+') ? '✅' : '❌';
            ?>
                <tr>
                    <td><?= htmlspecialchars($record['created_at']) ?></td>
                    <td><?= htmlspecialchars($record['medicine']) ?></td>
                    <td><?= htmlspecialchars($record['age']) ?></td>
                    <td><?= htmlspecialchars($record['weight']) ?></td>
                    <td><?= htmlspecialchars($record['dose']) ?></td>
                    <td><?= htmlspecialchars($record['daily_amount']) ?></td>
                    <td><?= htmlspecialchars($record['discomfort']) ?></td>
                    <td><?= htmlspecialchars($record['sub_discomfort']) ?></td>
                    <td><?= htmlspecialchars($record['guidance']) ?></td>
                    <td><?= htmlspecialchars($record['conclusion_rationale']) ?></td>
                    <td><?= $status ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
