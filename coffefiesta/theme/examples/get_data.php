<?php
include 'db.php';

$ilID = 35; // İstenilen ilID değerini belirtin

$sql = "SELECT * FROM siparis WHERE ilID = $ilID";
$result = $conn->query($sql);

$data = array(
    'categories' => array(),
    'values' => array()
);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($data['categories'], $row['siparisID']);
        array_push($data['values'], $row['ID']); // your_value_column, çubuk grafiği oluşturmak istediğiniz sütun adınız olmalı
    }
}

// Header'ı JSON olarak ayarla
header('Content-Type: application/json');

// JSON verisini yazdır
echo json_encode($data);

$conn->close();
?>