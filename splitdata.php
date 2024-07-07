<!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                            <li class="breadcrumb-item active">Split Data</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Split Data</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row button-split">
                                            <div class="col-6">
                                                <form action="functions/split_data.php?aksi=split" method="post">
                                                    <button id="splitDataButton" class="btn btn-success btn-block">Split Data</button>
                                                </form>    
                                            </div>
                                            <div class="col-6">
                                                <button type="button" name="delete" class="btn btn-block btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                            </div>
                                        </div>
                                        <div class="row mt-4 info-split">
                                            <div class="col-6">
                                                <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                                    <div class="card-header p-1 bg-light">
                                                        <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                                                Jumlah Data Training
                                                        </h6>
                                                    </div>
                                                    <div class="p-4 mini-stat-desc text-center bg-primary ">
                                                        <div class="clearfix">      
                                                                <?php
                                                                include "koneksi.php";
                                                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_training");
                                                                $query1 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_negative FROM data_training WHERE sentiment = 'hate speech'");
                                                                $query2 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_positive FROM data_training WHERE sentiment = 'non hate speech'");
                                                                $row = mysqli_fetch_assoc($query);
                                                                $row1 = mysqli_fetch_assoc($query1);
                                                                $row2 = mysqli_fetch_assoc($query2);
                                                                $count = $row['total'];
                                                                $negative = $row1['total_negative'];
                                                                $positive = $row2['total_positive'];
                                                                // echo "<h2 id='data_training'>$count</h2>"; // Tambahkan echo di sini
                                                                ?>   
                                                                <h2 id="data_training"><?= $count?></h2>
                                                                <h2>Hate <?= $negative ?></h2>
                                                                <h2>Non Hate <?= $positive ?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                                    <div class="card-header p-1 bg-light">
                                                        <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                                                Jumlah Data Testing
                                                        </h6>
                                                    </div>
                                                    <div class="p-4 mini-stat-desc text-center bg-primary">
                                                        <div class="clearfix">      
                                                                <?php
                                                                include "koneksi.php";
                                                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_testing");
                                                                $query1 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_negative FROM data_testing WHERE sentiment = 'hate speech'");
                                                                $query2 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_positive FROM data_testing WHERE sentiment = 'non hate speech'");
                                                                $row = mysqli_fetch_assoc($query);
                                                                $row1 = mysqli_fetch_assoc($query1);
                                                                $row2 = mysqli_fetch_assoc($query2);
                                                                $count = $row['total'];
                                                                $negative = $row1['total_negative'];
                                                                $positive = $row2['total_positive'];
                                                                // echo "<h2>$count</h2>"; // Tambahkan echo di sini
                                                                ?>   
                                                                <h2 id="data_testing"><?= $count?></h2>
                                                                <h2>Hate <?= $negative ?></h2>
                                                                <h2>Non Hate <?= $positive ?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <form action="functions/split_data.php?aksi=hapus" method="POST">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 text-center">
                               2020 - 2024 &copy; TA Deam Dharma Agung</a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
            <script>
                var data_testing =document.getElementById('data_testing')
                var data_training =document.getElementById('data_training')
                var splitDataButton = document.getElementById('splitDataButton');

                var trainingValue = parseInt(data_training.textContent);
                var testingValue = parseInt(data_testing.textContent);

                if (trainingValue > 0 && testingValue > 0) {
                    splitDataButton.disabled = true;
                   
                } else {
                    splitDataButton.disabled = false;
                    
                }

            
            </script>