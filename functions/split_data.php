<?php
// require "../config/koneksi.php"; // Memasukkan file koneksi database
if ($_GET['aksi'] == "split") {
    $host = 'localhost';
    $db   = 'ta'; // Ganti dengan nama database Anda
    $user = 'root'; // Ganti dengan user database Anda
    $pass = ''; // Ganti dengan password database Anda
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    function splitData(array $data, $testSize = 0.2) {
        $n = count($data);
        $nTest = (int) round($n * $testSize);  // Menghitung jumlah data uji
        shuffle($data);  // Mengacak data

        $testData = array_slice($data, 0, $nTest);  // Data untuk testing
        $trainData = array_slice($data, $nTest);  // Data untuk training

        return ['train' => $trainData, 'test' => $testData];
    }

    // Mengambil data dari database
    $query = "SELECT * FROM data_undersampling"; // Ganti 'nama_tabel' dengan nama tabel Anda
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll();

    // Memanggil fungsi splitData
    $splitData = splitData($data, 0.2);

    // Menyimpan data train ke tabel data_train
    foreach ($splitData['train'] as $trainData) {
        $insertQuery = "INSERT INTO data_training (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([$trainData['username'], $trainData['full_text'], $trainData['processed_text'], $trainData['sentiment'],]); // Sesuaikan dengan nama kolom dan data
    }

    // Menyimpan data test ke tabel data_test
    foreach ($splitData['test'] as $testData) {
        $insertQuery = "INSERT INTO data_testing (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([$testData['username'], $testData['full_text'], $testData['processed_text'], $testData['sentiment'],]); // Sesuaikan dengan nama kolom dan data
    }

    // Output jumlah data
    echo "Jumlah data latih disimpan: " . count($splitData['train']) . "<br>";
    echo "Jumlah data uji disimpan: " . count($splitData['test']) . "<br>";

    header("location: " . $_SERVER['HTTP_REFERER']);
} else if ($_GET['aksi'] == "hapus") {
    include "../koneksi.php";

    $querytraining = "DELETE FROM data_training";
    $resulttraining = mysqli_query($koneksi, $querytraining);
    $querytesting = "DELETE FROM data_testing";
    $resulttesting = mysqli_query($koneksi, $querytesting);
    
    if ($resulttesting && $resulttesting) {
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("location: " . $_SERVER['HTTP_REFERER']);
        
    }
    exit;
}

