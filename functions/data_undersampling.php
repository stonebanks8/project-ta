<?php

// Koneksi ke database
include '../koneksi.php';

if($_GET['aksi'] == "hapus") {
    $query = "DELETE FROM data_undersampling";
    
     // Eksekusi query
     if (mysqli_query($koneksi, $query)) {
         echo "Semua data berhasil dihapus dari tabel.";
     } else {
         echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
     }

    header("location: " . $_SERVER['HTTP_REFERER']);
} else if($_GET['aksi'] == 'undersampling') {
    // Atur seed untuk generator angka acak
    mt_srand(15);

    // Ambil data dari tabel 'label_lexicon'
    $sql = "SELECT username, full_text, sentiment FROM label_lexicon";
    $result = $koneksi->query($sql);

    // Pisahkan data ke dalam kelas yang berbeda
    $hate_speech_data = [];
    $non_hate_speech_data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['sentiment'] == 'non hate speech') {
                $hate_speech_data[] = $row;
            } else {
                $non_hate_speech_data[] = $row;
            }
        }
    } else {
        echo "Tidak ada data ditemukan";
        exit;
    }

    // Hitung jumlah sampel dari kelas minoritas (label 'hate speech')
    $minority_count = count($hate_speech_data);

    // Tentukan jumlah sampel yang diinginkan setelah undersampling
    $desired_count = $minority_count; // Menyesuaikan dengan jumlah sampel dari kelas minoritas

    // Lakukan undersampling pada kelas 'non_hate_speech'
    $undersampled_data = array_merge($hate_speech_data, array_slice($non_hate_speech_data, 0, $desired_count));

    // Acak urutan hasil undersampling
    shuffle($undersampled_data);

    // Simpan hasil undersampling ke dalam tabel baru 'data_undersampling'
    $table_name = 'data_undersampling';

    // Bersihkan tabel data_undersampling terlebih dahulu
    $truncate_sql = "TRUNCATE TABLE $table_name";
    if ($koneksi->query($truncate_sql) !== TRUE) {
        echo "Error: " . $truncate_sql . "<br>" . $koneksi->error;
        exit;
    }

    foreach ($undersampled_data as $data) {
        $username = $data['username'];
        $text = $data['full_text'];
        $label = $data['sentiment'];
        $sql = "INSERT INTO $table_name (username, full_text, sentiment) VALUES ('$username', '$text', '$label')";
        if ($koneksi->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }

    // Output pesan berhasil
    echo "Hasil undersampling telah disimpan ke dalam tabel '$table_name'";

    // Tutup koneksi ke database
    $koneksi->close();

    // Redirect ke data-undersampling.php
    header("location: " . $_SERVER['HTTP_REFERER']);
    exit;
}


?>
