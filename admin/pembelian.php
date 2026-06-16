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
    <style>
        body {
            background: linear-gradient(to right, #ff6a00, #ee0979);
        }
        .containera {
            background-color: #f0f4f8;
        }
        .sb-sidenav-dark {
            background-color: #34495e;
        }
        .sb-sidenav-menu a {
            color: #ecf0f1;
        }
        .sb-nav-link-icon {
            color: #ecf0f1;
        }
        .sb-sidenav-menu-heading {
            color: #ecf0f1;
        }
    </style>
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark">
            <!-- Navbar Brand-->
           <a class="navbar-brand ps-3" href="index.php"><img src="../assets/ple.png" width="28%"></img>   | Kasir Komponen     </a>
            <!-- Sidebar Toggle-->&nbsp;&nbsp;&nbsp;
            <!-- Sidebar Toggle-->
            <button class="btn btn-link d-md-inline-block btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="color:#FFFFFF;"></i></button>
        </nav> 
        <div class="containera" id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <div class="nav">
                            <div class="sb-sidenav-menu-heading"  style="color:#FFFFFF;">Menu</div>
                            <a class="nav-link" href="index.php" style="color:#FFFFFF;">
                                <div class="sb-nav-link-icon" style="color:#000000;"><i class="fas fa-home" style="color:#FFFFFF;"></i></div>
                                Beranda
                            </a>
                            <a class="nav-link" href="data_barang.php"  style="color:#FFFFFF;">
                                <div class="sb-nav-link-icon"  style="color:#FFFFFF;"><i class="fas fa-box-open"></i></div>
                        Barang
                            </a>
                            <a class="nav-link" href="pembelian.php"  style="color:#FFFFFF;">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart" style="color:#FFFFFF;"></i></div>
                                Pembelian
                            </a>
                            <a class="nav-link" href="laporan_penjualan.php"  style="color:#FFFFFF;">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line" style="color:#FFFFFF;"></i></div>
                                Data Laporan
                            </a>
                            <a class="nav-link" href="pengguna.php"  style="color:#FFFFFF;">
                                <div class="sb-nav-link-icon"><i class="fas fa-users" style="color:#FFFFFF;"></i></div>
                                Data Pengguna
                                </a><br>
                            <a class="nav-link" href="../logout.php" style="color:#FFFFFF;">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt" style="color:#FFFFFF;"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>


            <?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if (empty($_SESSION['level'])) {
    header("location:../index.php?pesan=gagal");
    exit(); // tambahkan exit untuk menghentikan eksekusi script setelah redirect
}

?>

<div class="card " id="layoutSidenav_content">
    <div class="card-body">
        <!-- Kolom Pencarian -->
        <form action="" method="get" class="mb-3">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="Cari Nama Pelanggan..." aria-label="Search" name="search">
                <button class="btn btn-outline-success" type="submit">
                    <i class="fas fa-search"></i> <!-- Ganti dengan icon pencarian yang diinginkan -->
                </button>
            </div>
        </form>

        <!-- Tombol Tambah Data -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-data">
            <i class="fas fa-plus"></i>&nbsp; Tambah Data
        </button>
    </div>

    <div class="card-body">
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
        <?php
        }
        ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Tanggal Penjualan</th>
                        <th>Total Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../conn.php';
                    $no = 1;

                    // Tanggapi parameter pencarian
                    $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : "";

                    $query = "SELECT * FROM pelanggan INNER JOIN penjualan ON pelanggan.PelangganID=penjualan.PelangganID";

                    if (!empty($search)) {
                        $query .= " WHERE NamaPelanggan LIKE '%$search%'";
                    }

                    $data = mysqli_query($conn, $query);

                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['PelangganID']; ?></td>
                            <td><?php echo $d['NamaPelanggan']; ?></td>
                            <td><?php echo $d['NomorTelepon']; ?></td>
                            <td><?php echo $d['TanggalPenjualan']; ?></td>
                            <td>Rp. <?php echo $d['TotalHarga']; ?></td>
                            <td>
                                <a class="btn btn-info btn-sm" href="detail_pembelian.php?PelangganID=<?php echo $d['PelangganID']; ?>">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?php echo $d['PelangganID']; ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?php echo $d['PelangganID']; ?>">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Data-->
                        <div class="modal fade" id="edit-data<?php echo $d['PelangganID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="update_pembelian.php" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="PelangganID" value="<?php echo $d['PelangganID']; ?>">
                                            <div class="form-group">
                                                <label>Nama Pelanggan</label>
                                                <input type="text" name="NamaPelanggan" value="<?php echo $d['NamaPelanggan']; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <input type="text" name="NomorTelepon" value="<?php echo $d['NomorTelepon']; ?>" class="form-control">
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

                        <!-- Modal Hapus Data-->
                        <div class="modal fade" id="hapus-data<?php echo $d['PelangganID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="hapus_pembelian.php">
                                        <div class="modal-body">
                                            <input type="hidden" name="PelangganID" value="<?php echo $d['PelangganID']; ?>">
                                            Apakah anda yakin akan menghapus data <b><?php echo $d['NamaPelanggan']; ?></b>
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
            <form action="simpan_pembelian.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" name="NamaPelanggan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="NomorTelepon" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Penjualan</label>
                        <input type="date" name="TanggalPenjualan" class="form-control">
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


