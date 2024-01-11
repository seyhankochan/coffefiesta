<?php
// duzenle.php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $kullaniciID = $_GET['id'];

    // Veritabanından kullanıcı bilgilerini getirme sorgusu
    require "db.php";

    $DBConnection = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $query = "SELECT kullaniciID, usertype, ad, soyad, email FROM users WHERE kullaniciID = ?";
        $statement = $DBConnection->prepare($query);
        $statement->execute([$kullaniciID]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Kullanıcı bilgilerini düzenleme formunu içeren HTML sayfasını oluştur
            ?>
            <form id="duzenleForm" method="post" action="guncelle.php">
                <input type="hidden" name="kullaniciID" value="<?php echo $user['kullaniciID']; ?>">
                
                <label for="usertype">Üyelik Türü:</label>
                <select name="usertype" id="usertype">
                    <option value="0" <?php echo ($user['usertype'] == 0) ? 'selected' : ''; ?>>Standart</option>
                    <option value="1" <?php echo ($user['usertype'] == 1) ? 'selected' : ''; ?>>Admin</option>
                </select>

                <label for="ad">Ad:</label>
                <input type="text" name="ad" id="ad" value="<?php echo $user['ad']; ?>">

                <label for="soyad">Soyad:</label>
                <input type="text" name="soyad" id="soyad" value="<?php echo $user['soyad']; ?>">

                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" value="<?php echo $user['email']; ?>">

                <button type="submit" class="btn btn-primary">Güncelle</button>
            </form>
            <?php
        } else {
            echo "Kullanıcı bulunamadı.";
        }
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