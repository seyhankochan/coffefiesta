<!DOCTYPE html>
<html lang="en">
<?php
// PHP oturumu başlatılır
session_start();

// Kullanıcı ID kontrolü yapılır
$kullaniciID = isset($_SESSION['Kullanici']) ? $_SESSION['Kullanici'] : null;

// Kullanıcı ID tanımlı değilse hata mesajı gösterilir
if ($kullaniciID === null) {
    echo "Hata: Kullanıcı ID tanımlı değil.";
    exit();
}

// Veritabanı bağlantısı yapılır
include 'db.php';

// Sipariş tablosunu kullanıcılar tablosuyla birleştirerek sorgu yapılır
$siparislerQuery = $DBConnection->prepare("SELECT siparis.*, users.ad, users.soyad FROM siparis JOIN users ON siparis.kullaniciID = users.kullaniciID");
$siparislerQuery->execute();

// Eğer sipariş bulunamazsa hata mesajı gösterilir
if ($siparislerQuery->rowCount() > 0) {
    $siparisler = $siparislerQuery->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Hata: Hiç sipariş bulunamadı.";
    header("refresh:3, url=dashboard.php");
    exit();
}
?>

<head>
    <!-- Meta etiketleri ve bağlantılar -->
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Now UI Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link href="../assets/demo/demo.css" rel="stylesheet" />

    <!-- Özel CSS stilleri -->
    <style>
        #siparisTable tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #siparisTable tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        #siparisTable thead th {
            background-color: #FF5733;
            color: #000;
            font-weight: bold;
        }
    </style>
</head>
<body class="">
    <!-- Sayfa içeriği -->
    <div class="wrapper">
        <?php
        // Kenar çubuğu ve navbar dosyaları dahil edilir
        require "sidebar.php";
        require "navbar.php";
        ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div style="margin-bottom: 150px;"></div>
                        <div class="text-center">
                            <div class="table-responsive">
                                <?php
                                // Sipariş tablosu oluşturulur
                                try {
                                    echo "<table id='siparisTable' class='table table-striped table-bordered'>";
                                    echo "<thead><tr><th>Ad</th><th>Soyad</th><th>Çeşit</th><th>Köken</th><th>Kavurma Derecesi</th><th>İl</th><th>İlçe</th><th>Sipariş Tarihi</th><th>İptal</th></tr></thead>";
                                    echo "<tbody>";
                                    foreach ($siparisler as $row) {
                                        echo "<tr><td>" . $row['ad'] . "</td><td>" . $row['soyad'] . "</td><td>" . $row['Cesit'] . "</td><td>" . $row['Koken'] . "</td><td>" . $row['Kavurma_Derecesi'] . "</td><td>" . $row['iladi'] . "</td><td>" . $row['ilceadi'] . "</td>";
                                        echo "<td>" . date('Y-m-d H:i:s', strtotime($row['anlik'])) . "</td>";
                                        echo "<td><button class='btn btn-danger btn-sm' onclick='iptalEt(" . $row['siparisID'] . ")'>İptal</button></td></tr>";
                                    }
                                    echo "</tbody></table>";
                                } catch (PDOException $e) {
                                    echo "Veritabanı bağlantısı veya sorgu hatası: " . $e->getMessage();
                                    exit();
                                } finally {
                                    $DBConnection = null;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // Altbilgi dosyası dahil edilir
        require "footer.php";
        ?>
    </div>
    <!-- JavaScript dosyaları -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.1.2/dist/echarts.min.js"></script>
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
    <script src="../assets/demo/demo.js"></script>
    <script>
        // Sayfa yüklendiğinde çalışacak JavaScript kodları
        $(document).ready(function() {
            $('#siparisTable').DataTable({
                "stripeClasses": ['even', 'odd'],
                "pagingType": "full_numbers"
            });
        });

        // İptal etme fonksiyonu
        function iptalEt(siparisID) {
            if (confirm("Siparişi iptal etmek istediğinize emin misiniz?")) {
                $.ajax({
                    type: "POST",
                    url: "iptal.php",
                    data: {siparisID: siparisID},
                    success: function(response) {
                        if (response === "success") {
                            location.reload();
                        } else {
                            alert("Silme işlemi sırasında bir hata oluştu.");
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>