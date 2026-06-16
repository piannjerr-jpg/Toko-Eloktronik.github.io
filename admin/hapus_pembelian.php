<?php 
// koneksi database
include '../conn.php';

// menangkap data id yang di kirim dari url
$PelangganID = $_POST['PelangganID'];

// hapus data dari tabel penjualan yang terkait
mysqli_query($conn, "DELETE FROM penjualan WHERE PelangganID='$PelangganID'");

// hapus data dari tabel pelanggan
mysqli_query($conn, "DELETE FROM pelanggan WHERE PelangganID='$PelangganID'");

// mengalihkan halaman kembali ke pembelian.php
header("location:pembelian.php?pesan=hapus");
?>
