<?php
    session_start();
    require 'db.php';
    
    header('Content-Type: application/json; charset=utf-8');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        $response = array("status" => "success", "message" => "");
    
        try {
            $user_id = (int) $_POST['user_id'];
            $medicine = $_POST['medicine'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $information =  $_POST['information'];
            $age = $_POST['age'];
            $weight = (double) $_POST['weight'];
            $dose = $_POST['dose'];
            $dailyAmount = $_POST['dailyAmount'];
            $discomfort = $_POST['discomfort'];
            $subdiscomfort = $_POST['subdiscomfort'];
            $guidance = $_POST['guidance'];
    
            $stmt = $conn->prepare("INSERT INTO Ills (user_id, medicine, name, surname, age, weight, dose, daily_amount, discomfort, sub_discomfort, guidance) 
                                     VALUES (:user_id, :medicine, :name, :surname, :age, :weight, :dose, :dailyAmount, :discomfort, :subdiscomfort, :guidance)");
    
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':medicine', $medicine, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_STR);
            $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
            $stmt->bindParam(':dose', $dose, PDO::PARAM_STR);
            $stmt->bindParam(':dailyAmount', $dailyAmount, PDO::PARAM_STR);
            $stmt->bindParam(':discomfort', $discomfort, PDO::PARAM_STR);
            $stmt->bindParam(':subdiscomfort', $subdiscomfort, PDO::PARAM_STR);
            $stmt->bindParam(':guidance', $guidance, PDO::PARAM_STR);
    
            $stmt->execute();
            $last_id = $conn->lastInsertId();
            $response["last_id"] = $last_id;
            $stmt->closeCursor();
    
        } catch (PDOException $e) {
            $response["status"] = "error";
            $response["message"] = "Bir hata oluştu: " . $e->getMessage();
        }
    
        echo json_encode($response);
    }
?>
