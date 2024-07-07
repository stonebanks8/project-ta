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
                                            <li class="breadcrumb-item active">Pengujian</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Pengujian</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h3 class="page-title m-0">Pengujian </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row model">
                                            <div class="col-12">
                                                <h6 class="card-title">Pilih Model : </h6>
                                                    <select class="form-control select2" name="model" id="model" onchange="onchangeModel(this.value)">
                                                        <option hidden>-- Pilih Model --</option>
                                                            <?php
                                                            include "koneksi.php";
                                                                    
                                                            // Query untuk mengambil semua data dari tabel data_model
                                                            $query = mysqli_query($koneksi, "SELECT model_name, positive_label, negative_label FROM data_model");
                                                                    
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                            $totalLabels = $row['positive_label'] + $row['negative_label'];
                                                            ?>
                                                            <option value="<?= $totalLabels; ?>,<?= $row['positive_label']; ?>,<?= $row['negative_label']; ?>,<?= $row['model_name']; ?>">
                                                            <?= $row['model_name']; ?>
                                                            </option>
                                                            <?php
                                                            }
                                                            ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="row data mt-4">
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-center text-white">Jumlah Data Uji</h6>
                                                            <?php
                                                            include "koneksi.php";
                                                            $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_testing");
                                                            $row = mysqli_fetch_assoc($query);
                                                            $count = $row['total'];
                                                            echo "<h2 class='text-white text-center'>$count</h2>"; // Tambahkan echo di sini
                                                            ?>
                                                            <!-- <h2 class='mb-4 text-white'>0</h2> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-white text-center">Jumlah Data Latih</h6>
                                                            <h2 id="text_total" class="text-white text-center">0</h2>
                                                            <!-- <h2 class='mb-4 text-white'>0</h2> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row sentiment mt-2">
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-white text-center">Sentiment Positive Data Latih</h6>
                                                            <h2 id="text_positif" class="text-white text-center">0</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-white text-center">Sentiment Negative Data Latih</h6>
                                                            <h2 id="text_negatif" class="text-white text-center">0</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="functions/pengujian.php" style="display: inline;">
                                                            <!-- <button type="submit" name="delete" class="btn btn-danger" >Hapus Data</button> -->
                                            <button type="submit" name="proses" class="btn btn-lg btn-block btn-primary">Mulai Pengujian</button>
                                        </form>           
                                </div>                        
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
                function onchangeModel(value) {
                    const myArray = value.split(",");
                    document.getElementById("text_total").innerHTML = myArray[0];
                    document.getElementById("text_positif").innerHTML = myArray[1];
                    document.getElementById("text_negatif").innerHTML = myArray[2];
                    document.getElementById("namaModel").value = myArray[3];
                    document.getElementById("jumlahSentimen").value = myArray[0];
                    document.getElementById("trainingPositif").value = myArray[1];
                    document.getElementById("trainingNegatif").value = myArray[2];
                    // document.getElementById("pengujianButton").disabled = false;
                }
            </script>

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