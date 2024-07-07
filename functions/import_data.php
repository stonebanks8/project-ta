<?php

include "../koneksi.php";

if($_GET['aksi'] == "hapus") {
    $query = "DELETE FROM data_raw";
    
     // Eksekusi query
     if (mysqli_query($koneksi, $query)) {
         echo "Semua data berhasil dihapus dari tabel.";
     } else {
         echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
     }

    header("location: " . $_SERVER['HTTP_REFERER']);
}


?>