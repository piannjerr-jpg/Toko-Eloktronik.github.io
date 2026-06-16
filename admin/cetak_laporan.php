<?php
session_start();

// Cek apakah pengguna sudah login
if (empty($_SESSION['level'])) {
    header("Location: ../index.php?pesan=gagal");
    exit(); // Hentikan eksekusi skrip setelah redirect
}

include '../conn.php';

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Penjualan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        @media print {
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h4>Laporan Penjualan Barang</h4>
            <p>Periode: 
            <?php 
            if ($start_date && $end_date) {
                echo date('d M Y', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($end_date));
            } else {
                echo "Semua Data";
            }
            ?>
            </p>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Menu</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Pendapatan</th>
                        <th>Tanggal Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mendapatkan data penjualan berdasarkan tanggal atau semua data
                    $query = "SELECT menu.MenuID, menu.NamaMenu, SUM(detailpenjualan.JumlahMenu) AS JumlahTerjual, 
                        SUM(detailpenjualan.Subtotal) AS TotalPendapatan, penjualan.TanggalPenjualan, pelanggan.PelangganID, pelanggan.NamaPelanggan
                        FROM menu
                        INNER JOIN detailpenjualan ON menu.MenuID = detailpenjualan.MenuID
                        INNER JOIN penjualan ON detailpenjualan.PenjualanID = penjualan.PenjualanID
                        INNER JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID";

                    if ($start_date && $end_date) {
                        // Tambahkan filter tanggal jika ada
                        if (strtotime($end_date) >= strtotime($start_date)) {
                            $query .= " WHERE penjualan.TanggalPenjualan BETWEEN '$start_date' AND '$end_date'";
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-danger'>Tanggal akhir tidak boleh sebelum tanggal awal.</td></tr>";
                        }
                    }

                    $query .= " GROUP BY menu.MenuID, menu.NamaMenu, penjualan.TanggalPenjualan
                                ORDER BY JumlahTerjual DESC";

                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['PelangganID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['NamaPelanggan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['NamaMenu']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['JumlahTerjual']) . "</td>";
                            echo "<td>Rp. " . number_format($row['TotalPendapatan'], 0, ',', '.') . "</td>";
                            echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['TanggalPenjualan']))) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data menu terjual untuk periode ini.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Cetak -->
    <div class="text mt-4">
        <button class="btn btn-danger" onclick="window.print()">Cetak Laporan</button>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
