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
                                            <li class="breadcrumb-item active">Modeling</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Modeling</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row mb-4">
                            <div class="col-12">
                                <form method="post" action="functions/modeling.php" style="display: inline;">
                                                    <!-- <button type="submit" name="delete" class="btn btn-danger" >Hapus Data</button> -->
                                    <button type="submit" name="proses" class="btn btn-block btn-primary">Mulai Modeling</button>
                                </form>
                            </div>
                    </div>
                </div>

                <div class="row label-lexicon">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="">
                                            <table id="datatable" class="ddatatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="">No</th>
                                                        <th class="text-center">Model Name</th>
                                                        <th class="">Positive Labels</th>
                                                        <th class="">Negative Labels</th>
                                                        <th class="">Total Sentiment</th>
                                                        <th class="text-center">Created At</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                        $query = mysqli_query($koneksi, "SELECT * FROM data_model");
                                                        $totalPositive = 0;
                                                        $totalNegative = 0;
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                            $totalPositive += $row['positive_label'];
                                                            $totalNegative += $row['negative_label'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>                                                   
                                                        <td><?= $row['model_name']; ?></td>
                                                        <td><?= $row['positive_label']; ?></td>
                                                        <td><?= $row['negative_label']; ?></td>
                                                        <td><?= $row['positive_label'] + $row['negative_label'] ; ?></td>
                                                        <td><?= $row['created_at'];?></td>
                                                        
                                                    </tr>
                                                    <?php   
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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