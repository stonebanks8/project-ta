<?php

$host = "localhost"; // Host database
$username = "root"; // Username database
$password = ""; // Password database
$database = "ta"; // Nama database

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}



?>