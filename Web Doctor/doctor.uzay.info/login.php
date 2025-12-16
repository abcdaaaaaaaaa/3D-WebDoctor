<?php
session_start();
require 'db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $TCKNO = $_POST['TCKNO'];

    try {
        $stmt = $conn->prepare("SELECT user_id, name, surname, date_of_birth, password, information FROM users WHERE name = :name AND surname = :surname");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($TCKNO, $user['password'])) {
            date_default_timezone_set('Europe/Istanbul');
            $userdate = $user['date_of_birth'];
            $date = new DateTime($userdate);
            $today =  new DateTime('now');
            $interval = $today->diff($date);
            $age = $interval->y + ($interval->m / 12) + ($interval->d / 365);
            $_SESSION['customAge'] = $interval->format('%y yıl %m ay %d gün');
            $_SESSION['age'] = round($age, 4);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $name;
            $_SESSION['surname'] = $surname;
            $_SESSION['information'] = $user['information'];
            header('Location: index.php');
            exit();
        } else {
            $error_message = "TCKNO veya Ad, Soyad bilgileriniz hatalı.";
        }
    } catch (PDOException $e) {
        $error_message = "Bir hata oluştu: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="shortcut icon" href="../images/doctor.ico">
    <link rel="stylesheet" href="loginstyle.css">
    <style>.form-container { max-width: 400px; }</style>
</head>
<body>
    <div class="form-container">
        <h2>Giriş Yap</h2>
        <form method="POST" action="">
            <label for="TCKNO">TC Kimlik Numarası:</label>
            <input type="text" id="TCKNO" name="TCKNO" required><br>
            <label for="name">Ad:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="surname">Soyad:</label>
            <input type="text" id="surname" name="surname" required><br>
            <button type="submit">Giriş Yap</button>
        </form>
        <?php if ($error_message) echo "<p style='color: red;'>$error_message</p>"; ?>
        <p>Hesabınız yok mu? <a href="/register">Kayıt Ol</a></p>
        <p>Eczane kaydı için buraya <a href="/cupboard">tıklaynız</a></p>

    </div>
</body>
</html>
