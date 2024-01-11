<?php
session_start();

if (!isset($_SESSION['Kullanici'])) {

    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_id = $_SESSION['Kullanici'];

    $cesit = $_POST['Cesit'];
    $koken = $_POST['Koken'];
    $kavurma_derecesi = $_POST['Kavurma_Derecesi'];
    $il = $_POST['iladi'];
    $ilce = $_POST['ilceadi'];
    $kartno = $_POST['kartno'];
    $date = $_POST['tarihi'];
    $cvv = $_POST['cvv'];
    $sozlesme = $_POST['sozlesme'];

    $query = "INSERT INTO siparis (kullaniciID, Cesit, Koken, Kavurma_Derecesi, iladi, ilceadi, kartno, tarihi, cvv, sozlesme) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $kullanici_id, $cesit, $koken, $kavurma_derecesi, $il, $ilce, $kartno, $date, $cvv, $sozlesme);
    
    if ($stmt->execute()) {
        echo "Siparişiniz başarıyla alındı!";
        header("Refresh: 2; URL=dashboard.php");
    } else {
        echo "Sipariş verirken bir hata oluştu: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>