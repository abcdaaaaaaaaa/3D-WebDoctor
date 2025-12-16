<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Web Doctor</title>
    <link rel="shortcut icon" href="../images/doctor.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="header">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/logout" class="button logout">Çıkış</a>
            <a href="/" class="button restart">Yeniden Başlat</a>
            <a href="/resume" class="button resume">Özgeçmiş</a>
        <?php else: ?>
            <a href="/login" class="button logout">Giriş</a>
        <?php endif; ?>
    </div>
    
    <div class="container">
        <div id="question" class="question"></div>
        <div class="doctorImage">
            <img id="doctorImage" src="../images/doctor.png" alt="Doctor Image">
        </div>
        <div id="optionsContainer">
            <div class="option" onclick="selectOption(1, 'Ağrı Sorunları')">Ağrı Sorunları</div>
            <div class="option" onclick="selectOption(2, 'Bulantı ve Mide Sorunları')">Bulantı ve Mide Sorunları</div>
            <div class="option" onclick="selectOption(3, 'Yüksek Ateş ve Yorgunluk')">Yüksek Ateş ve Yorgunluk</div>
            <div class="option" onclick="selectOption(4, 'Solunum Yolu ve Alerji Kaynaklı Rahatsızlıklar')">Solunum Yolu ve Alerji Kaynaklı Rahatsızlıklar</div>
        </div>
        <p id="selectedOptionText">Seçilen Rahatsızlık Belirtisi:</p>
        <div id="doseForm" class="dose-form hidden">
            <label for="weight">Kilo:</label>
            <input type="number" id="weight" name="weight" placeholder="kg < 10 ise 5.3 gibi kesirli sayı giriniz.">
            <button onclick="calculateDose()">Dozu Hesapla</button>
        </div>
            <p id="doseResult" class="dose-result"></p>
        <div id="inputContainerWrapper">
            <div id="inputContainer">
                <input type="temp" id="tempInput" placeholder="Örnek: Ateşim 37.2°C" />
                <button id="submitButton">Gönder</button>
            </div>
        </div>
    </div>
    
<script>
    let user_id = <?php echo json_encode($_SESSION['user_id']); ?>;
    let name = <?php echo json_encode($_SESSION['name']); ?>;
    let surname = <?php echo json_encode($_SESSION['surname']); ?>;
    let information = <?php echo json_encode($_SESSION['information']); ?>;
    let age = <?php echo json_encode($_SESSION['age']); ?>;
    let customAge = <?php echo json_encode($_SESSION['customAge']); ?>;
</script>

<script src="sentences.js"></script>
<script src="script.js"></script>
</body>
</html>
