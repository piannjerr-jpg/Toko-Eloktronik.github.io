
<?php 
// koneksi database
include '../conn.php';

// menangkap data yang di kirim dari form
$PelangganID = $_POST['PelangganID'];
$NamaPelanggan = $_POST['NamaPelanggan'];
$NomorTelepon = $_POST['NomorTelepon'];
$Alamat = $_POST['Alamat'];

// update data ke database
mysqli_query($conn,"update pelanggan set NamaPelanggan='$NamaPelanggan', NomorTelepon='$NomorTelepon', Alamat='$Alamat' where PelangganID='$PelangganID'");

// mengalihkan halaman kembali ke data_barang.php
header("location:pembelian.php?pesan=update");

?>