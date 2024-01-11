
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı girişi sırasında
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gelenemail = $_POST["email"];
    $gelensifre = $_POST["sifre"];

    if ($gelenemail != "" and $gelensifre != "") {
        $kullanicikontrol = $DBConnection->prepare("SELECT * FROM users WHERE email = ?");
        $kullanicikontrol->execute([$gelenemail]);
        $kullanici = $kullanicikontrol->fetch(PDO::FETCH_ASSOC);

        if ($kullanici && password_verify($gelensifre, $kullanici['sifre'])) {
            $_SESSION['Kullanici'] = $kullanici['kullaniciID'];
            $_SESSION['usertype'] = $kullanici['usertype'];

            session_regenerate_id(true);

            echo '<div class="alert alert-success">Giriş İşlemi Başarılı!</div>';

            if ($_SESSION['usertype'] == 1) {
                // Admin kullanıcısı ise admin_dashboard.php sayfasına yönlendir
                header("refresh:2, url=admin_dashboard.php");
            } elseif (isset($_GET['redirect'])) {
                // Başka bir sayfaya yönlendirme varsa o sayfaya yönlendir
                $redirectUrl = $_GET['redirect'];
                header("refresh:2, url=$redirectUrl");
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

// Sayfanın bulunduğu URL'yi al
$currentPage = $_SERVER['PHP_SELF'];
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Head içeriği buraya gelecek -->
</head>
<body>
    <div class="wrapper ">
        <div class="sidebar" data-color="orange">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                    <img src="logo.png" alt="Logo" width="30" height="30">
                </a>
                <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                    <img src="text.png" alt="coffeefiesta" width="120">
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="<?php echo (strpos($currentPage, 'dashboard.php') !== false ? 'active' : ''); ?>">
                        <a href="<?php echo ($_SESSION['usertype'] == 1 ? './admin_dashboard.php' : './dashboard.php'); ?>">
                            <i class="now-ui-icons business_chart-pie-36"></i>
                            <p>Anasayfa</p>
                        </a>
                    </li>
          <li class="' . (strpos($currentPage, 'notifications.html') !== false ? 'active' : '') . '">
            <a href="./order.php">
              <i class="now-ui-icons shopping_tag-content"></i>
              <p>Sipariş Ver</p>
            </a>
          </li>
          <li class="<?php echo (strpos($currentPage, 'activeorder.php') !== false ? 'active' : ''); ?>">
            <a href="./activeorder.php">
              <i class="now-ui-icons shopping_box"></i>
              <p>Siparişlerim</p>
            </a>
          </li>
          <li class="<?php echo (strpos($currentPage, 'product.php') !== false ? 'active' : ''); ?>">
            <a href="./product.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Ürün Listesi</p>
            </a>
          </li>
          <?php
                    if ($_SESSION['usertype'] == 1 || $_SESSION['usertype'] == 2) {
                        echo '<li class="' . (strpos($currentPage, 'usertable.php') !== false ? 'active' : '') . '">
                                <a href="./usertable.php">
                                    <i class="now-ui-icons users_single-02"></i>
                                    <p>Kullanıcılar</p>
                                </a>
                              </li>';
                    }
                    ?>
                    <?php
                    if ($_SESSION['usertype'] == 1 || $_SESSION['usertype'] == 2) {
                        echo '<li class="' . (strpos($currentPage, 'adduser.php') !== false ? 'active' : '') . '">
                                <a href="./adduser.php">
                                    <i class="now-ui-icons ui-1_simple-add"></i>
                                    <p>Kullanıcı Ekle</p>
                                </a>
                              </li>';
                    }
                    ?>
          <li class="<?php echo (strpos($currentPage, 'feedback.php') !== false ? 'active' : ''); ?>">
            <a href="./feedback.php">
              <i class="now-ui-icons files_single-copy-04"></i>
              <p>Öneri ve Şikayet</p>
            </a>
          </li>
        </ul>
      </div>
    </div>';
?>