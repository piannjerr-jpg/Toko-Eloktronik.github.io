<?php 
// koneksi database
include '../conn.php';

// menangkap data id yang di kirim dari url
$MenuID = $_POST['MenuID'];


// menghapus data dari database
mysqli_query($conn,"delete from menu where MenuID='$MenuID'");

// mengalihkan halaman kembali ke data_barang.php
header("location:data_barang.php?pesan=hapus");

?>