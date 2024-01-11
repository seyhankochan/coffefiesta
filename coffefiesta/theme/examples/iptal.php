<?php
session_start();

// Veritabanı bağlantısını sağladığınız dosyanın adını kullanın
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['siparisID'])) {
    $siparisID = $_POST['siparisID'];

    // Veritabanında siparişi silme sorgusu
    $silmeSorgusu = $DBConnection->prepare("DELETE FROM siparis WHERE siparisID = ?");
    $silmeSonucu = $silmeSorgusu->execute([$siparisID]);

    if ($silmeSonucu) {
        echo "success"; // Başarılı bir şekilde silindiğini belirten bir yanıt
    } else {
        echo "error"; // Silme sırasında bir hata oluştuğunu belirten bir yanıt
    }

    // Veritabanı bağlantısını kapat
    $DBConnection = null;
} else {
    // Eksik veya geçersiz parametreler
    echo "error";
}
?>