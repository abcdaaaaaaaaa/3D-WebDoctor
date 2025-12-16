<?php
session_start();
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ["status" => "success", "message" => ""];

    try {
        $user_id = (int) $_POST['user_id'];
        $medicine = $_POST['medicine'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $information = $_POST['information'];
        $ill_id = $_POST['ill_id'];
        $conclusion_rationale = $_POST['conclusion_rationale'];
        $detail_conclusion_rationale = $_POST['detail_conclusion_rationale'];
        $result = $_POST['result'];
        $pharmacy = $_POST['pharmacy'];
        $confirmation = $_POST['confirmation'];
        $name2 = $_POST['name2'];
        $surname2 = $_POST['surname2'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    

        $stmt = $conn->prepare("SELECT id, confirmation_code FROM pharmacies WHERE name = :pharmacy LIMIT 1");
        $stmt->bindParam(':pharmacy', $pharmacy, PDO::PARAM_STR);
        $stmt->execute();
        $pharmacy_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pharmacy_row) { throw new Exception("Eczane adı doğrulanamadı."); }
        $hashed_confirmation = $pharmacy_row['confirmation_code'];
        if (!password_verify($confirmation, $hashed_confirmation)) { throw new Exception("Onay kodu doğrulanamadı."); }
        $pharmacy_id = $pharmacy_row['id'];

        $stmt = $conn->prepare("INSERT INTO medicine_results (user_id, name, surname, information, ill_id, pharmacy, medicine, conclusion_rationale, detail_conclusion_rationale, result) 
                                VALUES (:user_id, :name, :surname, :information, :ill_id, :pharmacy, :medicine, :conclusion_rationale, :detail_conclusion_rationale, :result)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':information', $information, PDO::PARAM_STR);
        $stmt->bindParam(':ill_id', $ill_id, PDO::PARAM_STR);
        $stmt->bindParam(':pharmacy', $pharmacy, PDO::PARAM_STR);
        $stmt->bindParam(':medicine', $medicine, PDO::PARAM_STR);
        $stmt->bindParam(':conclusion_rationale', $conclusion_rationale, PDO::PARAM_STR);
        $stmt->bindParam(':detail_conclusion_rationale', $detail_conclusion_rationale, PDO::PARAM_STR);
        $stmt->bindParam(':result', $result, PDO::PARAM_STR);
        $stmt->execute();

        $medicine_result_id = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO pharmacy_records (pharmacy, pharmacy_id, pharmacist_name, pharmacist_surname, pharmacist_password, medicine_result_id, result) 
                                VALUES (:pharmacy, :pharmacy_id, :pharmacist_name, :pharmacist_surname, :pharmacist_password, :medicine_result_id, :result)");
        $stmt->bindParam(':pharmacy', $pharmacy, PDO::PARAM_STR);
        $stmt->bindParam(':pharmacy_id', $pharmacy_id, PDO::PARAM_INT);
        $stmt->bindParam(':pharmacist_name', $name2, PDO::PARAM_STR);
        $stmt->bindParam(':pharmacist_surname', $surname2, PDO::PARAM_STR);
        $stmt->bindParam(':pharmacist_password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':medicine_result_id', $medicine_result_id, PDO::PARAM_INT);
        $stmt->bindParam(':result', $result, PDO::PARAM_STR);
        $stmt->execute();

    } catch (Exception $e) {
        $response["status"] = "error";
        $response["message"] = $e->getMessage();
    }

    echo json_encode($response);
}
?>
