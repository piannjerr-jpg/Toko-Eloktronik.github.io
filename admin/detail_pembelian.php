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

        <?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if (empty($_SESSION['level'])) {
    header("location:../index.php?pesan=gagal");
    exit(); // tambahkan exit untuk menghentikan eksekusi script setelah redirect
}
?>

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
        <nav class="sb-topnav navbar navbar-expand navbar-dark ">
            <!-- Navbar Brand-->
           <a class="navbar-brand ps-3" href="index.php"><img src="../assets/ple.png" width="30%"></img> | Kasir Ramen</a>
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
                                <div class="sb-nav-link-icon" style="color:#FFFFFF;"><i class="	fas fa-box-open"></i></div>
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



<div class="card " id="layoutSidenav_content">
<div class="card-body">
        <?php
        include 'conn.php';
        $PelangganID = $_GET['PelangganID'];
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM pelanggan INNER JOIN penjualan ON pelanggan.PelangganID=penjualan.PelangganID");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <?php if ($d['PelangganID'] == $PelangganID) { ?>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Informasi Pelanggan :</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>ID Pelanggan :</th>
                                <td><?php echo $d['PelangganID']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Pelanggan :</th>
                                <td><?php echo $d['NamaPelanggan']; ?></td>
                            </tr>
                            <tr>
                                <th>No. Telepon :</th>
                                <td><?php echo $d['NomorTelepon']; ?></td>
                            </tr>
                            <tr>
                                <th>Alamat :</th>
                                <td><?php echo $d['Alamat']; ?></td>
                            </tr>
                            <tr>
                                <th>Total Pembelian :</th>
                                <td>Rp. <?php echo $d['TotalHarga']; ?></td>
                            </tr>
                        </table>

 <!-- Tombol Cetak Struk -->
 <div class="mt-3" >
                            <button id="btnCetakStruk" class="btn btn-success"><i class="fas fa-print me-2"></i>Cetak Struk</button>
                        </div>

                        <!-- Script untuk Mengarahkan ke Halaman Cetak Struk -->
                        <script>
                            document.getElementById('btnCetakStruk').addEventListener('click', function() {
                                // Ganti 'nama_halaman_struk.php' dengan nama halaman struk.php
                                window.location.href = 'struk.php?PenjualanID=<?php echo $d['PenjualanID']; ?>';
                            });
                        </script>
                    </div>
                        
                    <div class="col-md-6 text-end">
                        <form method="post" action="tambah_detail_penjualan.php">
                            <input type="text" name="PenjualanID" value="<?php echo $d['PenjualanID']; ?>" hidden>
                            <input type="text" name="PelangganID" value="<?php echo $d['PelangganID']; ?>" hidden>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i> Tambah Barang
                            </button>
                        </form>
                    </div>
                </div>


                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Beli</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../conn.php';
                        $nos = 1;
                        $detailpenjualan = mysqli_query($conn, "SELECT * FROM detailpenjualan");
                        while ($d_detailpenjualan = mysqli_fetch_array($detailpenjualan)) {
                        ?>
                            <?php
                            if ($d_detailpenjualan['PenjualanID'] == $d['PenjualanID']) { ?>
                                <tr>
                                    <td><?php echo $nos++; ?></td>
                                    <td>
                                        <form action="simpan_menu_beli.php" method="post">
                                            <div class="form-group">
                                                <input type="text" name="PelangganID" value="<?php echo $d['PelangganID']; ?>" hidden>
                                                <input type="text" name="DetailID" value="<?php echo $d_detailpenjualan['DetailID']; ?>" hidden>
                                                <select name="MenuID" class="form-control" onchange="this.form.submit()">
                                                    <option>--- Pilih Barang ---</option>
                                                    <?php
                                                    include '../conn.php';
                                                    $no = 1;
                                                    $menu = mysqli_query($conn, "SELECT * FROM menu");
                                                    while ($d_menu = mysqli_fetch_array($menu)) {
                                                    ?>
                                                        <option value="<?php echo $d_menu['MenuID']; ?>" <?php if ($d_menu['MenuID'] == $d_detailpenjualan['MenuID']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>><?php echo $d_menu['NamaMenu']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="hitung_subtotal.php">
                                            <?php
                                            include '../conn.php';
                                            $menu = mysqli_query($conn, "SELECT * FROM menu");
                                            while ($d_menu = mysqli_fetch_array($menu)) {
                                            ?>
                                                <?php
                                                if ($d_menu['MenuID'] == $d_detailpenjualan['MenuID']) { ?>
                                                    <input type="text" name="Harga" value="<?php echo $d_menu['Harga']; ?>" hidden>
                                                    <input type="text" name="MenuID" value="<?php echo $d_menu['MenuID']; ?>" hidden>
                                                    <input type="text" name="Stok" value="<?php echo $d_menu['Stok']; ?>" hidden>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <div class="form-group">
                                                <input type="number" name="JumlahMenu" value="<?php echo $d_detailpenjualan['JumlahMenu']; ?>" class="form-control">
                                            </div>
                                    </td>
                                    <td><?php echo $d_detailpenjualan['Subtotal']; ?>
                                    </td>
                                <td>
                                        <form method="post" action="hitung_subtotal.php">
                                            <input type="text" name="DetailID" value="<?php echo $d_detailpenjualan['DetailID']; ?>" hidden>
                                            <input type="text" name="PelangganID" value="<?php echo $d['PelangganID']; ?>" hidden>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fas fa-check me-2"></i> Proses
                                            </button>
                                        </form>
                                    
                                        <form class="mt-3" method="post" action="hapus_detail.php">
                                            <input type="text" name="PelangganID" value="<?php echo $d['PelangganID']; ?>" hidden>
                                            <input type="text" name="DetailID" value="<?php echo $d_detailpenjualan['DetailID']; ?>" hidden>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } else {
                            ?>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <form method="post" action="simpan_total_harga.php">
                    <?php
                    include '../conn.php';
                    $detailpenjualan = mysqli_query($conn, "SELECT SUM(Subtotal) AS TotalHarga FROM detailpenjualan WHERE PenjualanID='$d[PenjualanID]'");
                    $row = mysqli_fetch_assoc($detailpenjualan);
                    $sum = $row['TotalHarga'];
                    ?>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="text" class="form-control" name="TotalHarga" value="<?php echo $sum; ?>" readonly>
                                <input type="text" name="PelangganID" value="<?php echo $d['PelangganID']; ?>" hidden>
                                <input type="text" name="PenjualanID" value="<?php echo $d['PenjualanID']; ?>" hidden>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-info btn-sm form-control" type="submit">
                                    <i class="fas fa-save me-2"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } else { ?>
        <?php
            }
        }
        ?>
    </div>
    <div class="mt-3">
    <a href="pembelian.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Pembelian</a>
</div><?php include 'footer.php'; ?>
</div>

<!-- Tombol Kembali ke Halaman Pembelian -->


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


