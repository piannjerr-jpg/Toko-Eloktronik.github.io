<?php 
// koneksi database
include '../conn.php';

// menangkap data yang di kirim dari form
$Stok = $_POST['Stok'];
$MenuID = $_POST['MenuID'];
$JumlahMenu = $_POST['JumlahMenu'];
$Harga = $_POST['Harga'];
$DetailID = $_POST['DetailID'];
$PelangganID = $_POST['PelangganID'];
$Subtotal = $JumlahMenu * $Harga;
$Stok_total = $Stok - $JumlahMenu;

// menginput data ke database

mysqli_query($conn,"update detailpenjualan set Subtotal='$Subtotal', JumlahMenu='$JumlahMenu' where DetailID='$DetailID'");
mysqli_query($conn,"update menu set Stok='$Stok_total' where MenuID='$MenuID'");

// mengalihkan halaman kembali ke detail_pembelian.php
header("location:detail_pembelian.php?PelangganID=$PelangganID");
?>