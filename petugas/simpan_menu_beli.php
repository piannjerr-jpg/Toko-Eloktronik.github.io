<?php 
// koneksi database
include '../conn.php';

// menangkap data yang di kirim dari form
$MenuID = $_POST['MenuID'];
$DetailID = $_POST['DetailID'];
$PelangganID = $_POST['PelangganID'];

// menginput data ke database

mysqli_query($conn,"update detailpenjualan set MenuID='$MenuID' where DetailID='$DetailID'");

// mengalihkan halaman kembali ke detail_pembelian.php
header("location:detail_pembelian.php?PelangganID=$PelangganID");
?>