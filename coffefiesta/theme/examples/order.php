<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sipariş Ver</title>
  <?php
session_start();

if (!isset($_SESSION['Kullanici'])) {

    header("Location: login.php");
    exit();
}

$kullanici_id = $_SESSION['Kullanici'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$conn = new mysqli($servername, $username, $password, $dbname);

$queryKullanici = "SELECT * FROM `users` WHERE `kullaniciID` = ?";
$stmt = $conn->prepare($queryKullanici);
$stmt->bind_param("s", $kullanici_id);
$stmt->execute();
$resultKullanici = $stmt->get_result();

$kullanici_adi = '';
if ($resultKullanici->num_rows > 0) {
    $rowKullanici = $resultKullanici->fetch_assoc();
    $kullanici_adi = isset($rowKullanici['ad']) ? $rowKullanici['ad'] : '';
} else {

    echo '<div style="color: red;">Hata: Kullanıcı bilgileri bulunamadı.</div>';
    header("Refresh: 2; URL=login.php");
    exit();
}
if (isset($_POST['submit'])) {
  if (empty($_POST['Koken']) || empty($_POST['Kavurma_Derecesi']) || empty($_POST['iladi']) || empty($_POST['ilceadi']) || empty($_POST['kartno']) || empty($_POST['tarihi']) || empty($_POST['cvv']) || empty($_POST['sozlesme'])) {
    echo "<script>alert('Lütfen tüm alanları doldurunuz.');</script>";
  } else {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

      $cesit = isset($_POST["Cesit"]) ? $_POST["Cesit"] : '';
      $koken = isset($_POST["Koken"]) ? $_POST["Koken"] : '';
      $kavurma_derecesi = isset($_POST["Kavurma_Derecesi"]) ? $_POST["Kavurma_Derecesi"] : '';
      $iladi = isset($_POST["iladi"]) ? $_POST["iladi"] : '';
      $ilceadi = isset($_POST["ilceadi"]) ? $_POST["ilceadi"] : '';
      $kartno = isset($_POST["kartno"]) ? $_POST["kartno"] : '';
      $tarihi = isset($_POST["tarihi"]) ? $_POST["tarihi"] : '';
      $cvv = isset($_POST["cvv"]) ? $_POST["cvv"] : '';

          $query = "INSERT INTO siparis (Cesit, Koken, Kavurma_Derecesi, iladi, ilceadi, kartno, tarihi, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($query);
          if ($stmt) {
              $stmt->bind_param("ssssssss", $cesit, $koken, $kavurma_derecesi, $iladi, $ilceadi, $kartno, $tarihi, $cvv);

              if ($stmt->execute()) {

                  header("Location: ordersuccess.php");
                  exit();
              } else {
                  echo '<div style="color: red;">Hata: Sipariş verme sırasında bir sorun oluştu.</div>';
              }
          } else {
              echo '<div style="color: red;">Hata: SQL sorgusu hazırlanırken bir sorun oluştu.</div>';
          }
      }
  }
}
?>
  <?php
    $query = "SELECT * FROM `urun`";
    $result1 = mysqli_query($conn, $query);
  ?>

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
      margin: 0;
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

    select, input[type="text"], input[type="number"], input[type="cvv"], input[type="date"] {
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
    #cancel {
    height: 14px;
    width: 380px;
    display: inline-block;
    padding: 10px;
    background-color: #B4B4B4;
    color: #ffffff;
    font-size: 14px; /* Font büyüklüğü burada ayarlanıyor */
    border: none;
    border-radius: 15px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    margin-top: 10px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease;
  }

  #cancel:hover {
    background-color: #FFAA33;
  }
  </style>
</head>
<body>
  <div class="container">
    <h2>Sipariş Ver</h2>
    <form method="POST" action="ordersuccess.php">
      <div class="form-group">
        <label for="cesit">Çeşit:</label>
        <select id="cesit" name="Cesit">
          <option value="" selected disabled>Bir ürün seçin</option>
          <?php while ($row1 = mysqli_fetch_array($result1)): ?>
            <option value="<?php echo $row1['Cesit']; ?>"><?php echo $row1['Cesit']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="koken">Köken:</label>
        <select id="koken" name="Koken">
          <option value="" selected disabled>Bir ürün seçin</option>
          <?php
            $queryKoken = "SELECT DISTINCT Koken FROM `urun`";
            $resultKoken = mysqli_query($conn, $queryKoken);

            while ($rowKoken = mysqli_fetch_array($resultKoken)):
          ?>
            <option value="<?php echo $rowKoken['Koken']; ?>"><?php echo $rowKoken['Koken']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="kavurma_derecesi">Kavurma Derecesi:</label>
        <select id="kavurma_derecesi" name="Kavurma_Derecesi">
          <option value="" selected disabled>Bir ürün seçin</option>
          <?php
            $queryKavurmaDerecesi = "SELECT DISTINCT Kavurma_Derecesi FROM `urun`";
            $resultKavurmaDerecesi = mysqli_query($conn, $queryKavurmaDerecesi);

            while ($rowKavurmaDerecesi = mysqli_fetch_array($resultKavurmaDerecesi)):
          ?>
            <option value="<?php echo $rowKavurmaDerecesi['Kavurma_Derecesi']; ?>"><?php echo $rowKavurmaDerecesi['Kavurma_Derecesi']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="il">İl:</label>
        <select id="il" name="iladi">
          <option value="" selected disabled>Bir il seçin</option>
          <?php
            $queryIl = "SELECT DISTINCT iladi FROM `il`";
            $resultIl = mysqli_query($conn, $queryIl);

            while ($rowIl = mysqli_fetch_array($resultIl)):
          ?>
            <option value="<?php echo $rowIl['iladi']; ?>"><?php echo $rowIl['iladi']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="ilce">İlçe:</label>
        <select id="ilce" name="ilceadi">
          <option value="" selected disabled>Bir ilçe seçin</option>
          <?php
            $queryIlce = "SELECT DISTINCT ilceadi FROM `ilce`";
            $resultIlce = mysqli_query($conn, $queryIlce);

            while ($rowIlce = mysqli_fetch_array($resultIlce)):
          ?>
            <option value="<?php echo $rowIlce['ilceadi']; ?>"><?php echo $rowIlce['ilceadi']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="no">Kredi Kartı Numarası:</label>
        <input type="text" id="no" name="kartno">
      </div>
      <div class="form-group">
        <label for="date">Son Kullanma Tarihi:</label>
        <input type="date" id="date" name="tarihi">
      </div>
      <div class="form-group">
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv">
      </div>
      <div class="form-group">
      <div class="form-group">
  <input type="checkbox" name="sozlesme" value="1" checked> <a>Merhaba <?php echo $kullanici_adi; ?>,</a> Siparişi Onaylıyor musun?
</div>

      </div>
      <input type="submit" value="Sipariş Ver" id="go">
      <a href="dashboard.php" id="cancel">Vazgeç</a>
    </form>
  </div>
</body>
</html>