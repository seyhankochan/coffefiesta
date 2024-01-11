<?php
session_start();

// Kullanıcı oturumda giriş yapmış mı kontrol et
if (!isset($_SESSION['Kullanici'])) {
    // Kullanıcı giriş yapmamışsa, bir hata mesajı göster ve giriş sayfasına yönlendir
    echo '<div style="color: red;">Hata: Kullanıcı girişi yapılmamış.</div>';
    header("Refresh: 5; URL=login.php"); // Hata mesajını 5 saniye gösterdikten sonra giriş sayfasına yönlendir
    exit();
}

// Kullanıcı ID'sini al
$kullaniciID = $_SESSION['Kullanici'];

// Kullanıcı ID'sini ekrana yazdır
echo "Kullanıcı ID: " . $kullaniciID;
?>
