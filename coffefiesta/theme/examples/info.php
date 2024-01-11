<?php
// Oturumu başlat
session_start();

// Kullanıcı girişi kontrolü yapılır
if (!isset($_SESSION['Kullanici'])) {
    // Giriş yapılmamışsa, giriş sayfasına yönlendirilir
    header("Location: login.php");
    exit();
}

// Veritabanı bağlantısı yapılır
include 'db.php';

// Oturumda bulunan kullanıcı ID alınır
$userId = $_SESSION['Kullanici'];

// Kullanıcı kontrol sorgusu yapılır
$kullanicikontrol = $DBConnection->prepare("SELECT * FROM users WHERE kullaniciID = ?");
$kullanicikontrol->execute([$userId]);
$kullanici = $kullanicikontrol->fetch(PDO::FETCH_ASSOC);

// Hata ve onay mesajları için değişkenler tanımlanır
$hataMesaji = $onayMesaji = '';

// Form gönderildiyse işlemler yapılır
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $email = $_POST["email"];
    $mevcutSifre = $_POST["sifre"];
    $yeniSifre1 = $_POST["sifre1"];
    $yeniSifre2 = $_POST["sifre2"];

    $storedPassword = $kullanici['sifre'];

    // Mevcut şifre kontrol edilir
    if (password_verify($mevcutSifre, $storedPassword)) {

        // Yeni şifreler uyuşuyorsa güncelleme yapılır
        if ($yeniSifre1 == $yeniSifre2) {

            // Yeni şifre hashlenir
            $hashedYeniSifre = password_hash($yeniSifre1, PASSWORD_BCRYPT);

            // Kullanıcı bilgileri güncellenir
            $updateQuery = $DBConnection->prepare("UPDATE users SET ad = ?, soyad = ?, email = ?, sifre = ? WHERE kullaniciID = ?");
            $updateQuery->execute([$ad, $soyad, $email, $hashedYeniSifre, $userId]);

            // Onay mesajı gösterilir
            $onayMesaji = 'Profil güncellendi!';
        } else {
            // Yeni şifreler uyuşmuyorsa hata mesajı gösterilir
            $hataMesaji = 'Yeni şifreler uyuşmuyor!';
        }
    } else {
        // Mevcut şifre yanlışsa hata mesajı gösterilir
        $hataMesaji = 'Mevcut şifre yanlış!';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Düzenle</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #666;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #FF5733;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #FF5733;
        }

        /* Stil eklemeleri */
        .mesaj-kutusu {
            margin-top: 20px;
        }

        .hata-mesaji {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            padding: 10px;
        }

        .onay-mesaji {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Profil Düzenle</h2>
    

    <?php if ($hataMesaji): ?>
        <div class="mesaj-kutusu hata-mesaji">
            <?php echo $hataMesaji; ?>
        </div>
    <?php endif; ?>

    <?php if ($onayMesaji): ?>
        <div class="mesaj-kutusu onay-mesaji">
            <?php echo $onayMesaji; ?>
        </div>
    <?php endif; ?>


    <form method="post">
        <div class="form-group">
            <label for="ad">Ad:</label>
            <input type="text" class="form-control" name="ad" value="<?php echo $kullanici['ad']; ?>">
        </div>
        <div class="form-group">
            <label for="soyad">Soyad:</label>
            <input type="text" class="form-control" name="soyad" value="<?php echo $kullanici['soyad']; ?>">
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="text" class="form-control" name="email" value="<?php echo $kullanici['email']; ?>">
        </div>
        <div class="form-group">
            <label for="sifre">Mevcut Şifre:</label>
            <input type="password" class="form-control" name="sifre" value="">
        </div>
        <div class="form-group">
            <label for="sifre1">Yeni Şifre:</label>
            <input type="password" class="form-control" name="sifre1" value="">
        </div>
        <div class="form-group">
            <label for="sifre2">Yeni Şifre (Tekrar):</label>
            <input type="password" class="form-control" name="sifre2" value="">
        </div>
        <input type="submit" class="btn btn-success" value="Profil Güncelle">
    </form>
    <p><a href="logout.php">Çıkış Yap</a></p>
</div>

</body>
</html>