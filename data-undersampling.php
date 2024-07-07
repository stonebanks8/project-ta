<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Undersampling</title>
    <link href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
</head>

<body>
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                    <li class="breadcrumb-item active">Undersampling</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Undersampling</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Data Undersampling</h5>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <form action="functions/data_undersampling.php?aksi=undersampling" method="POST">
                                            <button class="btn btn-primary">Undersampling Data</button>
                                        </form>
                                    </div>
                                    <div class="col-6 p-2 text-right">
                                        <button type="button" name="delete" class="btn mr-2 btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Clean Text</th>
                                        <th>Sentiment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include 'koneksi.php';

                                        $sql = "SELECT username, full_text, sentiment FROM data_undersampling";
                                        $result = mysqli_query($koneksi, $sql);
                                        $query_positif = mysqli_query($koneksi, "SELECT * FROM data_undersampling WHERE sentiment = 'non hate speech'");
                                        $query_negatif = mysqli_query($koneksi, "SELECT * FROM data_undersampling WHERE sentiment = 'hate speech'");
                                    
                                        $total_positif = mysqli_num_rows($query_positif);
                                        $total_negatif = mysqli_num_rows($query_negatif);
                                        $total = mysqli_num_rows($result);
                                        if ($result === false) {
                                            die("Kueri SQL gagal: " . mysqli_error($koneksi));
                                        }

                                        if (mysqli_num_rows($result) > 0) {
                                            $nomor = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $background_color = $row['sentiment'] == 'hate speech' ? 'red' : 'green';

                                                echo "<tr>";
                                                // echo "<td>" . $nomor . "</td>";
                                                echo "<td>" . $row['username'] . "</td>";
                                                echo "<td>" . $row['full_text'] . "</td>";
                                                echo "<td style='background-color: $background_color; color: white; padding: 5px; text-align: center; font-weight: bold;'>" . ($row['sentiment'] == 'hate speech' ? 'Hate Speech' : 'Non Hate Speech') . "</td>";
                                                echo "</tr>";
                                                $nomor++;
                                            }
                                        } else {
                                            echo "<div class='row mt-4'>
                                            <div class='col-md-12'>
                                                <div class='alert alert-warning text-center' role='alert'>
                                                    Tidak ada data undersampling yang ditemukan.
                                                </div>
                                            </div>
                                        </div>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <h2>total <?= $total ?></h2>
                                <h2>hate <?= $total_negatif ?></h2>
                                <h2>non hate <?= $total_positif?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="functions/data_undersampling.php?aksi=hapus" method="POST">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center">
                           2020 - 2024 &copy; TA Deam Dharma Agung
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>