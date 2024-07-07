<?php

include "../koneksi.php";

if($_GET['aksi'] == "hapus") {
    $query = "DELETE FROM label_lexicon";
    
     // Eksekusi query
     if (mysqli_query($koneksi, $query)) {
         echo "Semua data berhasil dihapus dari tabel.";
     } else {
         echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
     }

    header("location: " . $_SERVER['HTTP_REFERER']);
} else if($_GET['aksi'] == "label") {
    $output = passthru('python ../labeling.py');

    header("location: " . $_SERVER['HTTP_REFERER']);
}

?>