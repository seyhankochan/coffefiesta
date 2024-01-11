<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8" />

  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Now UI Dashboard by Creative Tim</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- DataTables JavaScript -->
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

  <?php
  require "sidebar.php";
  require "navbar.php";
  ?>
<style>
    #siparisTable tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #siparisTable tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    #urunTable thead th {
      background-color: #FF5733;
      color: #000;
      font-weight: bold;
    }

    .action-buttons button {
      width: 90px;
    }
</style>
</head>

<body class="">
  <div class="mb-5"></div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="table-responsive" style="margin-top: 20px;">
          <?php
          require "db.php";

          if (session_status() === PHP_SESSION_NONE) {
            session_start();
          }

          $usertype = (isset($_SESSION['usertype'])) ? $_SESSION['usertype'] : 0;

          $DBConnection = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
          $DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          try {
            $query = "SELECT kullaniciID, usertype, ad, soyad, email FROM users";
            $statement = $DBConnection->query($query);
        
            echo "<table id='urunTable' class='table table-striped table-bordered'>";
            echo "<thead><tr><th>ID</th><th>Üyelik Türü</th><th>Ad</th><th>Soyad</th><th>Email</th>";
        
            if ($usertype == 1) {
                echo "<th>İşlemler</th>";
            }
        
            echo "</tr></thead>";
            echo "<tbody>";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['kullaniciID'] . "</td><td>" . $row['usertype'] . "</td><td>" . $row['ad'] . "</td><td>" . $row['soyad'] . "</td><td>" . $row['email'] . "</td>";
            
                if ($usertype == 1) {
                    echo "<td class='action-buttons'>
                            <button class='btn btn-danger btn-sm' onclick='sil(" . $row['kullaniciID'] . ")'>Sil</button>
                            <button class='btn btn-primary btn-sm' onclick='duzenle(" . $row['kullaniciID'] . ")'>Düzenle</button>
                          </td>";
                }
            
                echo "</tr>";
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

  <?php
  require "footer.php";
  ?>

<script>
    function sil(ID) {
        if (confirm("Bu kullanıcıyı silmek istediğinizden emin misiniz?")) {
            $.ajax({
                type: "POST",
                url: "sil.php",
                data: { id: ID },
                success: function (response) {
                    if (response === "success") {
                        alert("Kullanıcı başarıyla silindi");
                        window.location.reload();
                    } else {
                        alert("Kullanıcı silinirken bir hata oluştu");
                    }
                },
                error: function () {
                    alert("Bir hata oluştu");
                }
            });
        }
    }

    function duzenle(ID) {
        // Düzenle butonuna tıklandığında duzenle.php sayfasına yönlendir
        window.location.href = "duzenle.php?id=" + ID;
    }

    $(document).ready(function () {
        $('#urunTable').DataTable({
            "pageLength": 20,
            "lengthMenu": [10, 20, 30, 50],
        });
    });
</script>

</body>

</html>