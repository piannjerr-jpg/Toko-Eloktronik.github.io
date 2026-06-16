<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Halaman Administrator</title>
    <link rel="icon" href="../assets/icon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
           <a class="navbar-brand ps-3" href="index.php"><img src="../assets/kasir.png" width="50%"></img></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link d-md-inline-block btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav> 
        <div class="containera" id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Beranda
                            </a>
                            <a class="nav-link" href="data_barang.php">
                                <div class="sb-nav-link-icon"><i class="	fas fa-box-open"></i></div>
                                Barang
                            </a>
                            <a class="nav-link" href="pembelian.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pembelian
                            </a><br>
                            <a class="nav-link" href="../logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            
            <div class="card " id="layoutSidenav_content">
    <div class="card-body">
        <!-- Kolom Pencarian -->
        <form action="" method="get" class="mb-3">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="Cari Barang..." aria-label="Search" name="search">
                <button class="btn btn-outline-success" type="submit">
                    <i class="fas fa-search"></i> <!-- Ganti dengan icon pencarian yang diinginkan -->
                </button>
            </div>
        </form>

        <!-- Tombol Tambah Data -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-data">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <?php
        include 'conn.php';

        // Pengecekan apakah form pencarian di-submit
        if (isset($_GET['search'])) {
            // Jika ya, ambil nilai pencarian
            $cari = $_GET['search'];

            // Query pencarian
            $query = "SELECT * FROM menu WHERE NamaMenu LIKE '%$cari%' OR Harga LIKE '%$cari%' OR Stok LIKE '%$cari%'";
        } else {
            // Jika tidak, query tanpa pencarian
            $query = "SELECT * FROM menu";
        }

        // Eksekusi query
        $data = mysqli_query($conn, $query);
        ?>

        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "simpan") { ?>
                <div class="alert alert-success" role="alert">
                    Data Berhasil Di Simpan
                </div>
            <?php } ?>
            <?php if ($_GET['pesan'] == "update") { ?>
                <div class="alert alert-success" role="alert">
                    Data Berhasil Di Update
                </div>
            <?php } ?>
            <?php if ($_GET['pesan'] == "hapus") { ?>
                <div class="alert alert-success" role="alert">
                    Data Berhasil Di Hapus
                </div>
            <?php } ?>
            <?php if ($_GET['pesan'] == "gagal_nama_sama") { ?>
                <div class="alert alert-danger" role="alert">
                    Gagal menyimpan data. Nama menu sudah ada dalam database.
                </div>
            <?php } ?>
            <?php if ($_GET['pesan'] == "gagal_simpan") { ?>
                <div class="alert alert-danger" role="alert">
                    Gagal menyimpan data. Terjadi kesalahan saat menyimpan.
                </div>
            <?php } ?>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['NamaMenu']; ?></td>
                            <td>Rp. <?php echo $d['Harga']; ?></td>
                            <td><?php echo $d['Stok']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?php echo $d['MenuID']; ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?php echo $d['MenuID']; ?>">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Data-->
                        <div class="modal fade" id="edit-data<?php echo $d['MenuID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="update_barang.php" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="hidden" name="MenuID" value="<?php echo $d['MenuID']; ?>">
                                                <input type="text" name="NamaMenu" class="form-control" value="<?php echo $d['NamaMenu']; ?>">
                                                <input type="hidden" name="NamaMenuAwal" value="<?php echo $d['NamaMenu']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Barang</label>
                                                <input type="number" name="Harga" class="form-control" value="<?php echo $d['Harga']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Tambah Stok</label>
                                                <input type="number" name="TambahStok" class="form-control" value="0">
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus Data-->
                        <div class="modal fade" id="hapus-data<?php echo $d['MenuID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="hapus_barang.php">
                                        <div class="modal-body">
                                            <input type="hidden" name="MenuID" value="<?php echo $d['MenuID']; ?>">
                                            Apakah anda yakin akan menghapus data <b><?php echo $d['NamaMenu']; ?></b>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div> 
    <?php include 'footer.php'; ?>
</div>

<!-- Modal Tambah Data-->
<div class="modal fade animate__animated animate__fadeIn" id="tambah-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="simpan_barang.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="NamaMenu" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Harga Barang</label>
                        <input type="number" name="Harga" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Stok Barang</label>
                        <input type="number" name="Stok" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan library Font Awesome -->
<script src="https://kit.fontawesome.com/a6d8d75c07.js" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>


