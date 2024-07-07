            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                    <div class="row mb-3">
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="text-bold">DETEKSI UJARAN KEBENCIAN</h1>
                    </div>
                </div>
            </div>

                        <div class="row">

                            <!-- Data Raw-->
                            <?php
                            include 'koneksi.php';

                            $query = "SELECT COUNT(*) AS total_rows FROM data_raw";
                            $result = mysqli_query($koneksi, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $total_rows_dataraw = $row['total_rows'];
                            } else {
                                $total_rows_dataraw = "Error: " . mysqli_error($koneksi);
                            }

                            echo "<div class='col-md-6 col-xl-4'>
                            <div class='card' style='background-color: #00FFFF;'>
                                    <div class='card-body text-center'>
                                        <h5 class='card-title'>Data Raw</h5>
                                        <p class='text-danger'><strong style='font-size: 30px;'>$total_rows_dataraw</strong></p>
                                    </div>
                            </div>
                        </div>";
                            ?>
                            <!-- End of Data Raw-->

                            <!-- Data Preprocessing-->
                            <?php
                            include 'koneksi.php';

                            $query_preprocessing = "SELECT COUNT(*) AS total_rows FROM proses";
                            $result_preprocessing = mysqli_query($koneksi, $query_preprocessing);

                            if ($result_preprocessing) {
                                $row_preprocessing = mysqli_fetch_assoc($result_preprocessing);
                                $total_rows_preprocessing = $row_preprocessing['total_rows'];
                            } else {
                                $total_rows_preprocessing = "Error: " . mysqli_error($koneksi);
                            }

                            echo "<div class='col-md-6 col-xl-4'>
                            <div class='card' style='background-color: #00FFFF;'>
                                <a href='dataRaw.php' style='text-decoration: none; color: inherit;'>
                                    <div class='card-body text-center'>
                                        <h5 class='card-title'>Data Preprocessing</h5>
                                        <p class='text-success'><strong style='font-size: 30px;'>$total_rows_preprocessing</strong></p>
                                    </div>
                                </a>
                            </div>
                        </div>";
                            ?>
                            <!-- End of Data Preprocessing -->

                            <?php
                            include 'koneksi.php';

                            $query_labelData = "SELECT sentiment, COUNT(*) AS jumlah
                                                FROM label_lexicon
                                                GROUP BY sentiment;";
                            $result_labelData = mysqli_query($koneksi, $query_labelData);

                            $total_rows_label_0 = 0;
                            $total_rows_label_1 = 0;

                            if ($result_labelData) {
                                while ($row_labelData = mysqli_fetch_assoc($result_labelData)) {
                                    if ($row_labelData['sentiment'] == 'non hate speech') {
                                        $total_rows_label_0 = $row_labelData['jumlah'];
                                    } elseif ($row_labelData['sentiment'] == 'hate speech') {
                                        $total_rows_label_1 = $row_labelData['jumlah'];
                                    }
                                }
                            } else {
                                $total_rows_label_0 = "Error: " . mysqli_error($koneksi);
                                $total_rows_label_1 = "Error: " . mysqli_error($koneksi);
                            }

                            echo "<div class='col-md-6 col-xl-4'>
                            <div class='card' style='background-color: #00FFFF;'>
                                <div class='card-body text-center' style='font-size: 15px; color: #000000;'>
                                    <h5 class='card-title'>Label Data</h5>
                                    <p style='margin-bottom: -2px;'>Hate Speech      : <strong>$total_rows_label_1</strong></p>
                                    <p>Non Hate Speech  : <strong>$total_rows_label_0</strong></p>
                                </div>
                            </div>
                        </div>";
                            ?>

                        </div>

                        <div class="row">

                             <!-- Data Latih-->
                             <?php
                            include 'koneksi.php';

                            $query_latih = "SELECT COUNT(*) AS total_rows FROM data_training";
                            $result_latih = mysqli_query($koneksi, $query_latih);

                            if ($result_latih) {
                                $row_latih = mysqli_fetch_assoc($result_latih);
                                $total_rows_latih = $row_latih['total_rows'];
                            } else {
                                $total_rows_latih = "Error: " . mysqli_error($koneksi);
                            }

                            echo "<div class='col-md-6 col-xl-4'>
                            <div class='card' style='background-color: #00FFFF;'>
                                <div class='card-body text-center'>
                                    <h5 class='card-title' style='color: #343a40;'>Data Latih</h5>
                                    <p><strong style='font-size: 30px; color: #007bff;'>$total_rows_latih</strong></p>
                                </div>
                            </div>
                        </div>";
                        ?>
                        
                            <!-- End of Data Latih -->

                            <!-- Data Uji-->
                            <?php
                            include 'koneksi.php';

                            $query_uji = "SELECT COUNT(*) AS total_rows FROM data_testing";
                            $result_uji = mysqli_query($koneksi, $query_uji);

                            if ($result_uji) {
                                $row_uji = mysqli_fetch_assoc($result_uji);
                                $total_rows_uji = $row_uji['total_rows'];
                            } else {
                                $total_rows_uji = "Error: " . mysqli_error($koneksi);
                            }

                            echo "<div class='col-md-6 col-xl-4'>
                            <div class='card' style='background-color: #00FFFF;'>
                                <div class='card-body text-center'>
                                    <h5 class='card-title' style='color: #343a40;'>Data Uji</h5>
                                    <p><strong style='font-size: 30px; color: #FF7F00;'>$total_rows_uji</strong></p>
                                </div>
                            </div>
                        </div>";
                            ?>

                            <!-- End of Data uji -->

                            <!-- Data undersampling-->
                            <!-- <?php
                            include 'koneksi.php';

                            $query_undersampling = "SELECT COUNT(*) AS total_rows FROM data_undersampling";
                            $result_undersampling = mysqli_query($koneksi, $query_undersampling);

                            if ($result_undersampling) {
                                $row_undersampling = mysqli_fetch_assoc($result_undersampling);
                                $total_rows_undersamplig = $row_undersampling['total_rows'];
                            } else {
                                $total_rows_undersampling = "Error: " . mysqli_error($koneksi);
                            }

                            echo "<div class='col-md-6 col-xl-4'>
                            <div class='card' style='background-color: #00FFFF;'>
                                <div class='card-body text-center'>
                                    <h5 class='card-title' style='color: #343a40;'>Data Undersampling</h5>
                                    <p><strong style='font-size: 30px; color: #000000;'>$total_rows_undersamplig</strong></p>
                                </div>
                            </div>
                        </div>";
                            ?> -->

                            <?php
                            include 'koneksi.php';

                            $query_labelData = "SELECT sentiment, COUNT(*) AS jumlah
                                                FROM data_undersampling
                                                GROUP BY sentiment;";
                            $result_labelData = mysqli_query($koneksi, $query_labelData);

                            $total_rows_label_0 = 0;
                            $total_rows_label_1 = 0;

                            if ($result_labelData) {
                                while ($row_labelData = mysqli_fetch_assoc($result_labelData)) {
                                    if ($row_labelData['sentiment'] == 'non hate speech') {
                                        $total_rows_label_0 = $row_labelData['jumlah'];
                                    } elseif ($row_labelData['sentiment'] == 'hate speech') {
                                        $total_rows_label_1 = $row_labelData['jumlah'];
                                    }
                                }
                            } else {
                                $total_rows_label_0 = "Error: " . mysqli_error($koneksi);
                                $total_rows_label_1 = "Error: " . mysqli_error($koneksi);
                            }

                            echo "<div class='col-md-6 col-xl-4'>
                            <div class='card' style='background-color: #00FFFF;'>
                                <div class='card-body text-center' style='font-size: 15px; color: #000000;'>
                                    <h5 class='card-title'>Data Undersampling</h5>
                                    <p style='margin-bottom: -2px;'>Hate Speech      : <strong>$total_rows_label_1</strong></p>
                                    <p>Non Hate Speech  : <strong>$total_rows_label_0</strong></p>
                                </div>
                            </div>
                        </div>";
                            ?>
                          
                            <!--
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