<?php
session_start();
require 'db.php';

try {
    $conn->exec("SET NAMES 'utf8'");
    $conn->exec("SET CHARACTER SET utf8");
    $conn->exec("SET COLLATION_CONNECTION = 'utf8_general_ci'");

    $esp32_confirmation = $_GET['confirmation_code'] ?? '';

    if (empty($esp32_confirmation)) {
        echo "Hata: onay kodu eksik!";
        exit;
    }

    $sql = "SELECT pr.id as pharmacy_record_id, mr.name, mr.surname, mr.medicine, i.dose, i.daily_amount, p.medicine_order, p.confirmation_code, mr.created_at FROM pharmacy_records pr JOIN medicine_results mr ON pr.medicine_result_id = mr.id JOIN Ills i ON mr.ill_id = i.id JOIN pharmacies p ON pr.pharmacy_id = p.id WHERE mr.result = '+' AND mr.created_at >= DATE_SUB(NOW(), INTERVAL 10 MINUTE) ORDER BY mr.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $medicinesList = ["Ibuprofen", "Paracetamol", "Gaviscon", "Zyrtec"];
    $outputArray = [];

    foreach ($results as $row) {
        if (!password_verify($esp32_confirmation, $row['confirmation_code'])) {
            continue;
        }

        $medicineOrder = str_split($row['medicine_order']);
        $orderMap = [];

        foreach ($medicineOrder as $index => $orderNumber) {
            $drugName = $medicinesList[$index];
            $orderMap[$drugName] = (int)$orderNumber;
        }

        $medicineName = $row['medicine'];
        if ($medicineName == "Paracetamol mg EmergencyRoom") { $medicineName = "Paracetamol mg"; }

        $number = null;

        foreach ($orderMap as $medName => $num) {
            if (stripos($medicineName, $medName) !== false) {
                $number = $num;
                break;
            }
        }

        $fields = [$row['name'], $row['surname'], $medicineName, $row['dose'], $row['daily_amount'], $number ?? ''];
        $outputArray[] = implode(',', $fields);

        break;
    }

    $finalString = implode(';', $outputArray);
    echo $finalString;

} catch (PDOException $e) {
    echo "Veritabanı Hatası: " . $e->getMessage();
    exit;
}
?>
