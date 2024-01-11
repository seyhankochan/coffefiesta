<?php
// guncelle.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kullaniciID'])) {
    $kullaniciID = $_POST['kullaniciID'];
    $usertype = $_POST['usertype'];
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];

    // Veritabanına güncelleme sorgusu
    require "db.php";

    $DBConnection = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $query = "UPDATE users SET usertype = ?, ad = ?, soyad = ?, email = ? WHERE kullaniciID = ?";
        $statement = $DBConnection->prepare($query);
        $statement->execute([$usertype, $ad, $soyad, $email, $kullaniciID]);

        echo "Güncelleme Başarılı"; // Başarılı bir şekilde güncellendiğini belirten bir yanıt
        header("refresh:2, url=usertable.php");
    } catch (PDOException $e) {
        echo "Veritabanı bağlantısı veya sorgu hatası: " . $e->getMessage();
        exit();
    } finally {
        $DBConnection = null;
    }
} else {
    echo "Geçersiz istek.";
}
?>