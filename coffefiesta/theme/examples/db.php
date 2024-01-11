<?php
// Veritabanı bağlantı bilgileri
$hostname = 'localhost';
$database = 'proje';
$username = 'root';
$password = '';

try {
    // PDO nesnesi oluşturulur ve veritabanına bağlanılır
    $DBConnection = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    
    // PDO özellikleri ayarlanır
    $DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Bağlantı hatası durumunda hata mesajı gösterilir ve program sonlandırılır
    echo "Veritabanı bağlantısı hatası: " . $e->getMessage();
    exit();
}
?>