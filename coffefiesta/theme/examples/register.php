<!DOCTYPE html>
<html>
<head>
<title>Kayıt Ol</title>
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
  max-width: 400px;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  opacity: 80%;
}

h2 {
  text-align: center;
  color: #333333;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  color: #333333;
}

input[type="text"],
input[type="email"],
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
<h2>Kayıt Ol</h2>

<?php
  include 'db.php';
  $message = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];
    $sifre2 = $_POST["sifre2"];
    if (isset($_POST["onay"])){
        $onay = $_POST["onay"];
    }else{
        $onay = "";
    }
    if ($onay != ""){

        if ($sifre !=""  and $sifre2 !=""  and $email !=""){
            if ($sifre == $sifre2){

                $emailsorgusu = $DBConnection->prepare("select * from users where email = ? LIMIT 1");
                $emailsorgusu->execute([$email]);
                $emailsorgusayisi = $emailsorgusu->rowCount();

                if ($emailsorgusayisi > 0) {
                  echo '<div class="alert alert-danger">Email Adresi Kayıtlı</div>';
              } else {
                  if (strlen($sifre) < 4) {
                      echo '<div class="alert alert-danger">Şifre en az 4 karakter olmalıdır!</div>';
                  } else {

                      $hashedPassword = password_hash($sifre, PASSWORD_DEFAULT);
              
                      $KayıtSorgusu = $DBConnection->prepare("INSERT INTO users(ad, soyad, email, sifre, UyelikSozlesmesi, usertype) VALUES (?,?,?,?,?,?)");
                      $KayıtSorgusu->execute([$ad, $soyad, $email, $hashedPassword, $onay, 2]);
                      $KayıtSorgusuSayisi = $KayıtSorgusu->rowCount();
              
                      if ($KayıtSorgusuSayisi > 0) {
                          echo '<div class="alert alert-success">Kayıt Başarılı!</div>';
                          header("refresh:2, url=login.php");
                      } else {
                          echo '<div class="alert alert-danger">Kayıt Sistemi Sırasında Hata!, Tekrar Deneyiniz.</div>';
                      }
                  }
              }

            }else{
                echo '<div class="alert alert-danger">Şifreler Uyuşmuyor!</div>';
            }
        }else{
            echo '<div class="alert alert-danger">Lütfen Boş İçerikleri Doldurunuz</div>';
        }

    }else{
        echo '<div class="alert alert-danger">Üyelik Sözleşmesini Onaylamadınız!</div>';
    }
  }
  ?>
    <?php if ($message) { ?>
      <div class="alert alert-success"><?php echo $message; ?></div>
    <?php } ?>


    <form method="POST" action="register.php">
      <div class="form-group">
        <label for="ad">Ad:</label>
        <input type="text" id="ad" name="ad" >
      </div>

      <div class="form-group">
        <label for="soyad">Soyad:</label>
        <input type="text" id="soyad" name="soyad" >
      </div>
      
      <div class="form-group">
        <label for="email">E-posta:</label>
        <input type="email" id="email" name="email" >
      </div>
      
      <div class="form-group">
        <label for="sifre">Şifre:</label>
        <input type="password" id="sifre" name="sifre" >
      </div>

      <div class="form-group">
        <label for="sifre2">Şifre(Tekrar):</label>
        <input type="password" id="sifre2" name="sifre2" >
      </div>
      
      <div class="form-group">
        <input type="checkbox" name="onay" value="1" checked> <a class="text-warning" href="#">Üyelik sözleşmesini</a> okudum onaylıyorum.
        </div>

      <input type="submit" value="Kayıt Ol">
    </form>
