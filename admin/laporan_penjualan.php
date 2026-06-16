<?php
session_start();

// Cek apakah pengguna sudah login
if (empty($_SESSION['level'])) {
    header("Location: ../index.php?pesan=gagal");
    exit();
}

include '../conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            color: #fff;
        }
        .navbar {
            background: linear-gradient(to right, #ff6a00, #ee0979);
        }
        #layoutSidenav {
            display: flex;
            flex-direction: row;
        }
        #layoutSidenav_nav {
            width: 250px;
            background: rgba(0, 0, 0, 0.8);
            min-height: 100vh;
        }
        .sb-sidenav-menu a {
            color: #fff;
            padding: 10px 15px;
        }
        .sb-sidenav-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .table {
            background: rgba(255, 255, 255, 0.2);
        }
        .btn-danger {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand navbar-dark">
    <a class="navbar-brand ps-3" href="index.php">
       <img src="../assets/ple.png" width="18%"></img>   | Kasir Komponen     </a>
            <!-- Sidebar Toggle-->&nbsp;&nbsp;&nbsp;
</nav>

    <div id="layoutSidenav_content" class="flex-grow-1">
        <div class="container mt-4">
    <div class="card-body">
    <h3 style="color:#000000;">Laporan Barang Terjual</h3>
    
    <form method="post" action="laporan_penjualan.php">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_date" style="color:#000000;">Tanggal Awal:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_date" style="color:#000000;">Tanggal Akhir:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mt-4">Tampilkan Laporan</button>
                </div>
            </div>
        </div>
    </form>

    <?php
    // Tentukan query default
    $query = "SELECT menu.MenuID, menu.NamaMenu, SUM(detailpenjualan.JumlahMenu) AS JumlahTerjual, 
    SUM(detailpenjualan.Subtotal) AS TotalPendapatan, penjualan.TanggalPenjualan, pelanggan.PelangganID, pelanggan.NamaPelanggan
    FROM menu
    INNER JOIN detailpenjualan ON menu.MenuID = detailpenjualan.MenuID
    INNER JOIN penjualan ON detailpenjualan.PenjualanID = penjualan.PenjualanID
    INNER JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID";

    // Variabel untuk menyimpan filter tanggal
    $date_filter = '';

    // Tambahkan filter tanggal jika ada
    if (isset($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Validasi dasar untuk rentang tanggal
        if (strtotime($end_date) >= strtotime($start_date)) {
            $query .= " WHERE penjualan.TanggalPenjualan BETWEEN '$start_date' AND '$end_date'";
            $date_filter = "start_date=$start_date&end_date=$end_date";
        } else {
            echo "<p class='mt-4 text-danger'>Tanggal akhir tidak boleh sebelum tanggal awal.</p>";
        }
    }

    // Finalisasi query
    $query .= " GROUP BY menu.MenuID, menu.NamaMenu, penjualan.TanggalPenjualan
                ORDER BY JumlahTerjual DESC";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
    ?>
                    <a href="cetak_laporan.php?<?php echo $date_filter; ?>" class="btn btn-success">
                        <i class="fas fa-print me-2"></i>
                            Cetak PDF
                        </a>
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Terjual</th>
                                <th>Total Pendapatan</th>
                                <th>Tanggal Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
     $no = 1;
     ?>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['PelangganID']); ?></td>
                    <td><?php echo htmlspecialchars($row['NamaPelanggan']); ?></td>
                    <td><?php echo htmlspecialchars($row['NamaMenu']); ?></td>
                    <td><?php echo htmlspecialchars($row['JumlahTerjual']); ?></td>
                    <td>Rp. <?php echo number_format($row['TotalPendapatan'], 0, ',' , '.'); ?></td>
                    <td><?php echo htmlspecialchars($row['TanggalPenjualan']); ?></td>
            </tr>
        <?php } ?>
    </tbody>
                    </table>
                    <div class="mt-4">
                        <a href="index.php?<?php echo $date_filter; ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                    <?php
                    } else {
                        echo "<p class='mt-4'>Tidak ada data menu terjual untuk periode ini.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
