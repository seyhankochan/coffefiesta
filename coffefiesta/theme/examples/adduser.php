<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Ekleme Formu</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

h2 {
    color: #333;
    text-align: center;
    margin-top: 50px;
}

form {
    width: 100%;
    max-width: 500px;
    margin: 20px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    width: calc(100% - 20px);
    display: block;
    margin-bottom: 10px;
    color: #333;
    text-align: left; /* Labelleri sola hizala */
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s;
    box-sizing: border-box;
    display: block;
    margin-bottom: 20px;
    text-align: center; /* Input alanlarını ortala */
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
select:focus {
    border-color: #6699cc;
}

input[type="submit"],
button {
    width: calc(100% - 20px);
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #FF5733;
    color: #fff;
    font-weight: bold;
}

input[type="submit"]:hover {
    background-color: #5585b8;
}

button {
    margin-top: 10px;
    background-color: #ddd;
    color: #333;
}

button:hover {
    background-color: #ccc;
}

input[type="checkbox"] {
    margin-bottom: 10px;
}

.checkbox-container {
    width: calc(100% - 20px);
    display: flex;
    align-items: center;
}

.message {
    text-align: center;
    margin: 20px auto;
    padding: 10px;
    border-radius: 5px;
    background-color: #66bb6a;
    color: #fff;
    max-width: 300px;
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
}

    </style>
</head>
<body>

<h2>Kullanıcı Ekleme Formu</h2>

<?php
// Veritabanı bağlantısı için bilgiler
$servername = "localhost"; // Sunucu adı
$username = "root"; // Kullanıcı adı
$password = ""; // Şifre
$dbname = "proje"; // Veritabanı adı

// Veritabanı bağlantısı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$message = '';

// Form submit edildi mi kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Session değişkeni kontrolü
    if (!isset($_SESSION['form_submitted'])) {
        // Formdan gelen verileri al
        $kullaniciTipi = isset($_POST['kullaniciTipi']) ? $_POST['kullaniciTipi'] : '';
        $ad = isset($_POST['ad']) ? $_POST['ad'] : '';
        $soyad = isset($_POST['soyad']) ? $_POST['soyad'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $sifre = isset($_POST['sifre']) ? password_hash($_POST['sifre'], PASSWORD_BCRYPT, ['cost' => 10]) : ''; // Şifreyi bcrypt ile şifrele
        $onay = isset($_POST['onay']) ? 1 : 0; // Checkbox işaretli ise 1, değilse 0

        // Hata kontrolü
        if (empty($kullaniciTipi) || empty($ad) || empty($soyad) || empty($email) || empty($sifre)) {
            $message = "Lütfen tüm alanları doldurun.";
        } else {
            // SQL sorgusu
            $sql = "INSERT INTO users (usertype, ad, soyad, email, sifre, UyelikSozlesmesi) VALUES ('$kullaniciTipi', '$ad', '$soyad', '$email', '$sifre', '$onay')";

            // Sorguyu çalıştır
            if ($conn->query($sql) === TRUE) {
                $message = "Yeni kullanıcı başarıyla eklendi";
                header("refresh:2, url=adduser.php");
            } else {
                $message = "Hata: " . $sql . "<br>" . $conn->error;
            }

            // Session değişkenini ayarla
            $_SESSION['form_submitted'] = true;
        }
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="kullaniciTipi">Kullanıcı Tipi:</label>
    <select id="kullaniciTipi" name="kullaniciTipi" required>
        <option value="" selected disabled>Kullanıcı Tipi Seçiniz</option>
        <option value="1">Kullanıcı Tipi 1(Admin)</option>
        <option value="2">Kullanıcı Tipi 2(Kullanıcı)</option>
    </select>

    <label for="ad">Ad:</label>
    <input type="text" id="ad" name="ad" required>

    <label for="soyad">Soyad:</label>
    <input type="text" id="soyad" name="soyad" required>

    <label for="email">E-posta:</label>
    <input type="email" id="email" name="email" required>

    <label for="sifre">Şifre:</label>
    <input type="password" id="sifre" name="sifre" required>

    <div class="checkbox-container">
        <input type="checkbox" id="onay" name="onay">
        <label for="onay">Kullanıcı Ekle.</label>
    </div>

    <!-- Formun Sonu -->
<input type="submit" value="Kullanıcı Ekle">
<button onclick="location.href='dashboard.php'" type="button">Vazgeç</button>
</form>

<?php if (!empty($message)): ?>
    <div class="message">
        <?php echo $message; ?>
    </div>
    <script>
        // Sayfa yenileme işlemi
        setTimeout(function(){
            window.location.reload();
        }, 3000); // 3000 milisaniye (3 saniye) sonra sayfayı yenile
    </script>
<?php endif; ?>

</body>
</html>
