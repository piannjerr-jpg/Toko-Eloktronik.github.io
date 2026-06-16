<?php
session_start();

// Pastikan user sudah login
if (empty($_SESSION['level'])) {
    header("location:../index.php?pesan=gagal");
    exit(); 
}

// Pastikan PenjualanID tersedia dalam URL
if (!isset($_GET['PenjualanID'])) {
    header("location:pembelian.php");
    exit();
}

// Sertakan file koneksi
include '../conn.php';

// Ambil data penjualan berdasarkan PenjualanID dari URL
$PenjualanID = $_GET['PenjualanID'];
$query_penjualan = "SELECT * FROM penjualan WHERE PenjualanID = ?";
$stmt_penjualan = $conn->prepare($query_penjualan);
$stmt_penjualan->bind_param("i", $PenjualanID);
$stmt_penjualan->execute();
$result_penjualan = $stmt_penjualan->get_result();

if ($result_penjualan->num_rows === 0) {
    header("location:pembelian.php");
    exit();
}

$data_penjualan = $result_penjualan->fetch_assoc();

// Ambil data pelanggan berdasarkan PelangganID dari data penjualan
$PelangganID = $data_penjualan['PelangganID'];
$query_pelanggan = "SELECT * FROM pelanggan WHERE PelangganID = ?";
$stmt_pelanggan = $conn->prepare($query_pelanggan);
$stmt_pelanggan->bind_param("i", $PelangganID);
$stmt_pelanggan->execute();
$result_pelanggan = $stmt_pelanggan->get_result();
$data_pelanggan = $result_pelanggan->fetch_assoc();

// Generate nomor nota secara acak
$nomor_nota = mt_rand(100000, 999999);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        /* Gaya dapat disesuaikan sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        h2 {
            text-align: center;
        }
        .info {
            margin-bottom: 10px;
        }
        .info span {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Struk Pembelian</h2>
        <div class="info">
            <p><span>Tanggal:</span> <?php echo date("d/m/Y"); ?></p>
            <p><span>Nomor Nota:</span> <?php echo $nomor_nota; ?></p>
            <p><span>ID Pelanggan:</span> <?php echo $data_pelanggan['PelangganID']; ?></p>
            <p><span>Nama Pelanggan:</span> <?php echo $data_pelanggan['NamaPelanggan']; ?></p>
            <p><span>Alamat:</span> <?php echo $data_pelanggan['Alamat']; ?></p>
            <p><span>No. Telepon:</span> <?php echo $data_pelanggan['NomorTelepon']; ?></p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data detail pembelian berdasarkan PenjualanID
                $query_detail = "SELECT dp.*, p.NamaMenu, p.Harga 
                                 FROM detailpenjualan dp 
                                 INNER JOIN menu p ON dp.MenuID = p.MenuID 
                                 WHERE dp.PenjualanID = ?";
                $stmt_detail = $conn->prepare($query_detail);
                $stmt_detail->bind_param("i", $PenjualanID);
                $stmt_detail->execute();
                $result_detail = $stmt_detail->get_result();
                $no = 1;
                $total = 0;
                while ($data_detail = $result_detail->fetch_assoc()) {
                    $subtotal = $data_detail['JumlahMenu'] * $data_detail['Harga'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data_detail['NamaMenu']; ?></td>
                        <td><?php echo $data_detail['JumlahMenu']; ?></td>
                        <td>Rp <?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Total:</td>
                    <td>Rp <?php echo number_format($total, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script>
        // Cetak struk otomatis saat halaman dimuat
        window.print();
    </script>
</body>
</html>
