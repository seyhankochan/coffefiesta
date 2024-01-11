<?php
// Oturumu başlat
session_start();

// Oturumda kullanıcı varsa, zaten giriş yapmış demektir, dashboard sayfasına yönlendir
if (isset($_SESSION['Kullanici'])) {
  header("Location: dashboard.php");
  exit();
}

// Veritabanı bağlantısı yapılır
include 'db.php';

// Form gönderildiyse işlemler yapılır
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gelenemail = $_POST["email"];
    $gelensifre = $_POST["sifre"];

    // Boş değer kontrolü yapılır
    if ($gelenemail != "" and $gelensifre != "") {
        // Kullanıcı sorgusu yapılır
        $kullanicikontrol = $DBConnection->prepare("SELECT * FROM users WHERE email = ?");
        $kullanicikontrol->execute([$gelenemail]);
        $kullanici = $kullanicikontrol->fetch(PDO::FETCH_ASSOC);

        // Kullanıcı var ve şifre doğruysa oturum başlatılır
        if ($kullanici && password_verify($gelensifre, $kullanici['sifre'])) {
            $_SESSION['Kullanici'] = $kullanici['kullaniciID'];
            $_SESSION['usertype'] = $kullanici['usertype']; // usertype kontrolü ekleniyor
            
            session_regenerate_id(true);
            
            echo '<div class="alert alert-success">Giriş İşlemi Başarılı!</div>';
            
            if ($_SESSION['usertype'] == '1') {
                // Admin sayfasına yönlendir
                header("refresh:2, url=admin_dashboard.php");
            } else {
                // Diğer kullanıcılar için normal sayfaya yönlendir
                header("refresh:2, url=dashboard.php");
            }
            exit();
        } else {
            echo '<div class="alert alert-danger">Bu Bilgilere Ait Kullanıcı Bulunamadı!</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Lütfen Boş Değer Göndermeyin!</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Giriş Yap</title>

  <style>
    body {
      background-image: url("as.png");
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      overflow: hidden;
    }

    .container {
      width: 300px;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      opacity: 80%;
    }

    h2 {
      color: #333333;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #333333;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #cccccc;
      border-radius: 15px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #FF5733;
      color: #ffffff;
      border: none;
      border-radius: 15px;
      cursor: pointer;
      margin-top: 10px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #FFAA33;
    }

    .alert {
      margin-bottom: 10px;
      padding: 10px;
      color: #ffffff;
      border-radius: 3px;
      opacity: 0.9;
    }

    .alert-success {
      background-color: #28a745;
    }

    .alert-danger {
      background-color: #dc3545;
    }
    </style>
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <form method="post">
      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="text" class="form-control" name="email">
      </div>
      <div class="form-group">
        <label for="sifre">Şifre:</label>
        <input type="password" class="form-control" name="sifre">
      </div>
      <input type="submit" value="Giriş Yap">
    </form>
    <p><a href="register.php">Kayıt Ol</a></p>
  </div>
</body>
</html>