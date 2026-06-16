<?php 
// koneksi database
include '../conn.php';

// menangkap data yang di kirim dari form
$NamaMenu = $_POST['NamaMenu'];
$Harga = $_POST['Harga'];
$Stok = $_POST['Stok'];

// periksa apakah nama Menu sudah ada dalam database
$query = "SELECT * FROM menu WHERE NamaMenu = '$NamaMenu'";
$result = mysqli_query($conn, $query);

// jika hasil query mengembalikan baris data (nama Menu sudah ada), berikan pesan kesalahan
if(mysqli_num_rows($result) > 0) {
    // nama Menu sudah ada, kembalikan ke halaman data_barang.php dengan pesan error
    header("location:data_barang.php?pesan=gagal_nama_sama");
    exit(); // hentikan eksekusi script
} else {
    // nama Menu belum ada, lakukan penyimpanan ke database
    mysqli_query($conn,"INSERT INTO menu (NamaMenu, Harga, Stok) VALUES ('$NamaMenu','$Harga','$Stok')");
    // kembalikan ke halaman data_barang.php dengan pesan sukses
    header("location:data_barang.php?pesan=simpan");
}
?>
