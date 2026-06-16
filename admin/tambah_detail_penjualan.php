<?php 
// koneksi database
include '../conn.php';

// menangkap data yang di kirim dari form
$PelangganID = $_POST['PelangganID'];
$PenjualanID = $_POST['PenjualanID'];

// menginput data ke database
mysqli_query($conn,"insert into detailpenjualan values('','$PenjualanID','','','')");

// mengalihkan halaman kembali ke detail_pembelian.php
header("location:detail_pembelian.php?PelangganID=$PelangganID");
?>