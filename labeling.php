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
                                            <li class="breadcrumb-item active">Labeling</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Labeling</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        </div>
                        <!-- <div class="row label">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4 row">
                                            <div class="col-6 p-2">
                                                <button class="btn btn-primary">Tampilkan Data</button>
                                            </div>
                                            <div class="col-6 p-2 text-right">
                                            <form action="functions/import_data.php?aksi=hapus" method="POST" style="display: inline;">
                                                <button class="btn mr-2 btn-danger">Hapus Data</button>
                                            </form>
                                            </div>
                                        </div>
                                         <div class="">
                                            <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="">Username</th>
                                                        <th class="">Clean Text</th>
                                                        <th class="">Sentimen</th>
                                                        <th class="">Action</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM label");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <tr data-id="<?= $row['id']; ?>">                                                   
                                                        <td><?= $row['username']; ?></td>
                                                        <td><?= $row['full_text']; ?></td>
                                                        <td class="col-2">
                                                            <select class="form-control sentiment-dropdown" data-id="<?= $row['id']; ?>">
                                                                <option value="" selected>-- Pilih --</option>
                                                                <option value="Positif" <?php echo ($row['sentiment'] == 'Positif') ? 'selected' : ''; ?>>Positif</option>
                                                                <option value="Negatif" <?php echo ($row['sentiment'] == 'Negatif') ? 'selected' : ''; ?>>Negatif</option>
                                                                <option value="Netral" <?php echo ($row['sentiment'] == 'Negatif') ? 'selected' : ''; ?>>Netral</option>
                                                            </select>
                                                        </td>
                                                        <td></td>
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
                        </div> -->
                        
                        <div class="row label-lexicon">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4 row">
                                            <div class="col-6 p-2">
                                                <form action="functions/labeling.php?aksi=label" method="POST">
                                                    <button class="btn ml-2 btn-primary">Labeling Data</button>
                                                </form>
                                            </div>
                                            <div class="col-6 p-2 text-right">
                                                <form action="functions/labeling.php?aksi=hapus" method="POST" style="display: inline;">
                                                    <button type="button" name="delete" class="btn mr-2 btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="">
                                            <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Username</th>
                                                        <th class="text-center">Clean Text</th>
                                                        <th class="">Sentimen</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM label_lexicon");
                                                    $query_positif = mysqli_query($koneksi, "SELECT * FROM label_lexicon WHERE sentiment = 'non hate speech'");
                                                    $query_negatif = mysqli_query($koneksi, "SELECT * FROM label_lexicon WHERE sentiment = 'hate speech'");
                                                
                                                    $total_positif = mysqli_num_rows($query_positif);
                                                    $total_negatif = mysqli_num_rows($query_negatif);
                                                    $total = mysqli_num_rows($query);
                                                   
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $background_color = $row['sentiment'] == 'hate speech' ? 'red' : 'green';
                                                    ?>
                                                    <tr data-id="<?= $row['id']; ?>">                                                   
                                                        <td><?= $row['username']; ?></td>
                                                        <td><?= $row['full_text']; ?></td>
                                                        <td style='background-color: <?= $background_color ?>; color: white; padding: 5px; text-align: center; font-weight: bold;'><?=  ($row['sentiment'] == 'hate speech' ? 'Hate Speech' : 'Non Hate Speech') ?></td>
                                                        <!-- <td class="col-2">
                                                            <select class="form-control sentiment-dropdown" data-id="<?= $row['id']; ?>">
                                                                <option value="" selected>-- Pilih --</option>
                                                                <option value="Positif" <?php echo ($row['sentiment'] == 'non hate speech') ? 'selected' : ''; ?>>Positif</option>
                                                                <option value="Negatif" <?php echo ($row['sentiment'] == 'hate speech') ? 'selected' : ''; ?>>Negatif</option>
                                                            </select>
                                                        </td> -->
                                                    </tr>
                                                    <?php   
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
                            <!-- <h5 class="mr-3">Positif : <?php echo $total_positif; ?></h5>
                            <h5 class="mr-3">Negatif : <?php echo $total_negatif; ?></h5>
                            <h5>Netral : <?php echo $total_netral; ?></h5> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                    // Memilih semua dropdown sentiment
                    var sentimentDropdowns = document.querySelectorAll('.sentiment-dropdown');

                    // Menambahkan event listener untuk setiap dropdown
                    sentimentDropdowns.forEach(function (dropdown) {
                        dropdown.addEventListener('change', function () {
                            var id = dropdown.getAttribute('data-id');
                            var sentiment = dropdown.value;

                            // Kirim permintaan Ajax ke server untuk memperbarui data
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'update_sentiment.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    console.log('Data updated successfully');
                                } else {
                                    console.log('Failed to update data');
                                }
                            };
                            xhr.send('id=' + id + '&sentiment=' + sentiment);
                        });
                    });
                });
        </script>

            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6>Apakah anda yakin ingin menghapus data ini?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                            <form method="post" action="functions/labeling.php?aksi=hapus" style="display: inline;">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

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