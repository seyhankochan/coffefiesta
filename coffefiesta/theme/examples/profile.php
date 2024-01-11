<?php
// Session başlat
session_start();

// Eğer oturum başlatılmamışsa giriş sayfasına yönlendir
if (!isset($_SESSION['Kullanici'])) {
    header('Location: login.php?error=not_logged_in');
    exit();
}

// Kullanıcı bilgilerini göster
if (isset($_SESSION['Kullanici'])) {
    echo "Hoş geldiniz, " . $_SESSION['Kullanici']['ad'] . "!";
    echo "<img src='" . $_SESSION['profil_resmi'] . "' alt='Profil Resmi'>";
} else {
    echo "Oturum açmamışsınız.";
}

// Profil resmini göster
echo "<img src='" . $_SESSION['profil_resmi'] . "' alt='Profil Resmi'>";
?>