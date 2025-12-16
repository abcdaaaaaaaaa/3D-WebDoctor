<?php
require 'db.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pharmacy = $_POST['pharmacy'] ?? '';
    $confirmation = $_POST['confirmation'] ?? '';

    if ($confirmation === '') {
        $stmt = $conn->prepare("SELECT * FROM pharmacies WHERE LOWER(name) = LOWER(:pharmacy) LIMIT 1");
        $stmt->bindParam(':pharmacy', $pharmacy, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) { echo json_encode(["status" => "success"]); } 
        else { echo json_encode(["status" => "error", "message" => "Eczane adı doğrulanamadı."]); }
        exit;
    } else {
        $stmt = $conn->prepare("SELECT confirmation_code FROM pharmacies WHERE LOWER(name) = LOWER(:pharmacy) LIMIT 1");
        $stmt->bindParam(':pharmacy', $pharmacy, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($confirmation, $row['confirmation_code'])) { echo json_encode(["status" => "success"]); }
        else { echo json_encode(["status" => "error", "message" => "Onay kodu doğrulanamadı."]); }
        exit;
    }
}
?>
