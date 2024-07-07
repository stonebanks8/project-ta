
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
                                            <li class="breadcrumb-item active">Preprocessing</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Preprocessing</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row mb-4">
                            <div class="col-12">
                            <form method="post" action="functions/preprocessing.php?aksi=proses" style="display: inline;">
                                <!-- <button type="submit" name="delete" class="btn btn-danger" >Hapus Data</button> -->
                            <button type="submit" name="proses" class="btn btn-block btn-primary">Preprocessing</button>
                            </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30 shadow-sm bg-body-tertiary">
                                    <div class="card-header shadow-sm bg-body-tertiary">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-title">Data Preprocessing</h4>
                                            <!-- <form action="functions/preprocessing.php?aksi=hapus" method="POST" style="display: inline;"> -->
                                            <button type="button" name="delete" class="btn mr-2 btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">Full Text</th>
                                                <th class="text-center">Clean Text</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    include "koneksi.php";

                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM proses");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <tr>
                                                            <!-- <td><?= $no++; ?></td> -->
                                                            <td><?= $row['username']; ?></td>
                                                           <td><?= $row['full_text']; ?></td>
                                                            <td><?= $row['processed_text']; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30 shadow-sm bg-body-tertiary">
                                    <div class="card-header shadow-sm bg-body-tertiary">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="card-title">Data Clean</h6>
                                            <button class="btn btn-sm btn-danger">Hapus Data Clean</button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Clean Text</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    include "koneksi.php";

                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM proses");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                            <tr>
                                                                <?= $no++; ?>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= $row['processed_text']; ?></td>
                                                            </tr>
                                                    <?php
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

          <!-- Modal -->
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
                        <form action="functions/preprocessing.php?aksi=hapus" method="POST">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end row -->
                        
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