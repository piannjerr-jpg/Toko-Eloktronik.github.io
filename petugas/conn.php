<?php
//koneksi
$conn=mysqli_connect("localhost","root","","kasir");

if(mysqli_connect_errno()){

	echo "koneksi ke database gagal".mysqli_connect_errno();
}

?>
