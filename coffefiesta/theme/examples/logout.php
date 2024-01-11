<?php
session_start(); // Oturumu başlat

// Oturumu kontrol et ve varsa sonlandır
if (isset($_SESSION['Kullanici']) || isset($_SESSION['Admin'])) {
    session_destroy(); // Oturumu sonlandır

    // Oturum başarıyla sonlandıysa mesaj göster
    $message = "Oturum başarıyla sonlandırıldı.";
} else {
    // Kullanıcı zaten oturumda değilse, giriş sayfasına yönlendir
    $message = "Oturum açık değil, oturum sonlandırılamadı.";
}

// Kullanıcıya mesajı göster
echo "<p>$message</p>";

// Giriş sayfasına yönlendir
header("refresh:2; url=login.php");
exit();
?>