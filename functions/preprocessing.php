<?php
session_start();
include "../koneksi.php";

// Tingkatkan batas waktu eksekusi
set_time_limit(300); // 300 detik atau 5 menit

if ($_GET['aksi'] == "proses") {
    $output = passthru("python ../preprocessing.py");
    header("location: " . $_SERVER['HTTP_REFERER']);
    exit;
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../koneksi.php";

    error_log("POST request received"); // Debugging line

    $query = "DELETE FROM proses";
    if (mysqli_query($koneksi, $query)) {
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("location: " . $_SERVER['HTTP_REFERER']);
        
    }
    exit;
}
?>
