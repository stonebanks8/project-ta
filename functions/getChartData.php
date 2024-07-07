<?php
// Koneksi ke database menggunakan PDO
$dsn = 'mysql:host=localhost;dbname=ta';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Mengambil data riwayat dari database
$query = $pdo->query("SELECT * FROM riwayat");
$riwayats = $query->fetchAll(PDO::FETCH_ASSOC);

// Menyiapkan data untuk chart
$dataChart = [];
foreach ($riwayats as $riwayat) {
    $dataChart[] = [
        'created_at' => $riwayat['created_at'],
        'predict_positive' => (int) $riwayat['predict_positive'],
        'predict_negative' => (int) $riwayat['predict_negative'],
    ];
}

// Mengeluarkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($dataChart);
?>