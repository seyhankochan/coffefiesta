<?php
session_start();

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $kullaniciID = $_POST['id'];

    // Veritabanında kullanıcıyı silme sorgusu
    $silmeSorgusu = $DBConnection->prepare("DELETE FROM urun WHERE ID = ?");
    $silmeSonucu = $silmeSorgusu->execute([$kullaniciID]);

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