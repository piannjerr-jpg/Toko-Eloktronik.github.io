<?php 
// koneksi database
include '../conn.php';

// menangkap data yang di kirim dari form
$NamaPelanggan = $_POST['NamaPelanggan'];
$NomorTelepon = $_POST['NomorTelepon'];
$Alamat = $_POST['Alamat'];
$TanggalPenjualan = $_POST['TanggalPenjualan'];
$TanggalPenjualan = $_POST['TanggalPenjualan'];

try {
    // Periksa apakah nama pelanggan sudah ada dalam database
    $checkExistence = mysqli_query($conn, "SELECT COUNT(*) FROM pelanggan WHERE NamaPelanggan = '$NamaPelanggan'");
    $isExist = mysqli_fetch_row($checkExistence)[0];

    // Jika nama pelanggan sudah ada, tampilkan pesan kesalahan
    if ($isExist > 0) {
        header("location:pembelian.php?pesan=namapelangganada");
        exit();
    }

    // Membuat ID Pelanggan secara acak (contoh: angka acak antara 100000 dan 999999)
    $PelangganID = rand(100000, 999999);

    // Periksa apakah ID Pelanggan sudah ada, jika ada, buat yang baru
    $checkExistence = mysqli_query($conn, "SELECT COUNT(*) FROM pelanggan WHERE PelangganID = '$PelangganID'");
    $isExist = mysqli_fetch_row($checkExistence)[0];

    while ($isExist > 0) {
        $PelangganID = rand(100000, 999999);
        $checkExistence = mysqli_query($conn, "SELECT COUNT(*) FROM pelanggan WHERE PelangganID = '$PelangganID'");
        $isExist = mysqli_fetch_row($checkExistence)[0];
    }

    // menginput data ke database
    mysqli_query($conn, "INSERT INTO pelanggan (PelangganID, NamaPelanggan, Alamat, NomorTelepon) VALUES ('$PelangganID', '$NamaPelanggan', '$Alamat', '$NomorTelepon')");
    
    // Memasukkan data ke dalam tabel penjualan
    mysqli_query($conn, "INSERT INTO penjualan (TanggalPenjualan, PelangganID) VALUES ('$TanggalPenjualan', '$PelangganID')");

    // mengalihkan halaman kembali ke pembelian.php dengan pesan berhasil
    header("location:pembelian.php?pesan=simpan");
} catch (mysqli_sql_exception $e) {
    // Menangkap kesalahan dan menampilkan pesan kesalahan
    echo "Error: " . $e->getMessage();
}
?>
