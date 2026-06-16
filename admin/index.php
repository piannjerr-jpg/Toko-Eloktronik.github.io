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
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .card img {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .card img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <a class="navbar-brand ps-3" href="index.php"><img src="../assets/ple.png" width="28%"></img>   | Kasir Komponen     </a>
            <!-- Sidebar Toggle-->&nbsp;&nbsp;&nbsp;
    <button class="btn btn-link d-md-inline-block btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars" style="color:#FFFFFF;"></i>
    </button>
</nav>
<div class="containera" id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading" style="color:#FFFFFF;">Menu</div>
                    <a class="nav-link" href="index.php" style="color:#FFFFFF;">
                        <div class="sb-nav-link-icon" style="color:#FFFFFF;"><i class="fas fa-home"></i></div>
                        Beranda
                    </a>
                    <a class="nav-link" href="data_barang.php" style="color:#FFFFFF;">
                        <div class="sb-nav-link-icon" style="color:#FFFFFF;"><i class="	fas fa-box-open"></i></div>
                        Barang
                    </a>
                    <a class="nav-link" href="pembelian.php" style="color:#FFFFFF;">
                        <div class="sb-nav-link-icon" style="color:#FFFFFF;"><i class="fas fa-shopping-cart"></i></div>
                        Pembelian
                    </a>
                    <a class="nav-link" href="laporan_penjualan.php" style="color:#FFFFFF;">
                        <div class="sb-nav-link-icon" style="color:#FFFFFF;"><i class="fas fa-chart-line"></i></div>
                        Data Laporan
                    </a>
                    <a class="nav-link" href="pengguna.php" style="color:#FFFFFF;">
                        <div class="sb-nav-link-icon" style="color:#FFFFFF;"><i class="fas fa-users"></i></div>
                        Data Pengguna
                    </a><br>
                    <a class="nav-link" href="../logout.php" style="color:#FFFFFF;">
                        <div class="sb-nav-link-icon" style="color:#FFFFFF;"><i class="fas fa-sign-out-alt"></i></div>
                        Logout
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card text-center shadow">
                            <div class="card-body">
                                <img src="../assets/kom.png" width="57%"></img>
                                <h4 class="mt-3">Barang</h4>
                                <?php
                                include 'conn.php';
                                $data_produk = mysqli_query($conn, "SELECT * FROM menu");
                                $jumlah_produk = mysqli_num_rows($data_produk);
                                ?>
                                <p class="lead"><?php echo $jumlah_produk; ?> Barang</p>
                                <a href="data_barang.php" class="btn btn-primary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card text-center shadow">
                            <div class="card-body">
                                <img src="../assets/ko.jpg" width="80%"></img>
                                <h4 class="mt-3">Pembelian</h4>
                                <?php
                                $data_penjualan = mysqli_query($conn, "SELECT * FROM penjualan");
                                $jmlh_penjualan = mysqli_num_rows($data_penjualan);
                                ?>
                                <p class="lead"><?php echo $jmlh_penjualan; ?> Penjualan</p>
                                <a href="pembelian.php" class="btn btn-success btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card text-center shadow">
                            <div class="card-body">
                                <img src="../assets/logoo.png" width="35%"></img>
                                <h4 class="mt-3">Pengguna</h4>
                                <?php
                                $data_petugas = mysqli_query($conn, "SELECT * FROM petugas");
                                $jumlah_petugas = mysqli_num_rows($data_petugas);
                                ?>
                                <p class="lead"><?php echo $jumlah_petugas; ?> Petugas </p>
                                <a href="pengguna.php" class="btn btn-secondary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>
