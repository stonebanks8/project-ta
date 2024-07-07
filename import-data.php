    <?php
        include "koneksi.php";

        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM data_raw");
        $total = mysqli_num_rows($query);
    ?>
    
    
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
                                            <li class="breadcrumb-item active">Import Data</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Import Data</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Import</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>Anda bisa melakukan import data dengan format : </p>
                                        <ul>
                                            <li>CSV</li>
                                            <li>XLS</li>
                                            <li>XLX</li>
                                            <li>XLSX</li>
                                        </ul>
                                        <form action="import-process.php" method="post" enctype="multipart/form-data">
                                            <div class="mb-3 col-4">
                                                <label class="form-lable">Default file input</label>
                                                <input type="file" name="excel_file" id="excel_file" class="form-control-file filestyle" accept=".xls, .xlsx, .csv" data-buttonname="btn-secondary" onchange="onChangeFile(this.value)" <?php if($total != 0) echo 'disabled' ?>>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <button type="submit" id="btnSubmit" class="btn btn-primary waves-effect waves-light" >Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-title">Data Raw</h4>
                                            <!-- <form action="functions/import_data.php?aksi=hapus" method="POST" style="display: inline;"> -->
                                                <button type="button" name="delete" class="btn mr-2 btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatable" class="basic-datatables table table-bordered dt-responsive " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">Created At</th>
                                                <th class="text-center">Real Text</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php                                            
                                            while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                                <tr>
                                                    <!-- <td><?= $no++; ?></td> -->
                                                    <td class="col-2"><?= $row['username']; ?></td>
                                                    <td class="col-2"><?= $row['created_at']; ?></td>
                                                    <td class="col-8"><?= $row['full_text']; ?></td>
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
                        <form action="functions/import_data.php?aksi=hapus" method="POST">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->