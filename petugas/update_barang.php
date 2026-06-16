<?php
// Include file koneksi.php untuk menghubungkan ke database
include '../conn.php';

// Menangkap data yang dikirim dari form atau request
$MenuID = $_POST['MenuID'];
$NamaMenu = $_POST['NamaMenu']; 
$Harga = $_POST['Harga']; 
$tambahStok = $_POST['TambahStok']; // Jumlah stok yang ingin ditambahkan

// Query untuk mengambil stok awal Menu berdasarkan ID Menu
$queryStokAwal = "SELECT Stok FROM menu WHERE MenuID = $MenuID";
$resultStokAwal = mysqli_query($conn, $queryStokAwal);

// Memeriksa apakah Menu dengan ID tersebut ada dalam database
if(mysqli_num_rows($resultStokAwal) > 0) {
    // Mendapatkan nilai stok awal
    $row = mysqli_fetch_assoc($resultStokAwal);
    $stokAwal = $row['Stok'];

    // Menghitung stok baru setelah penambahan
    $stokBaru = $stokAwal + $tambahStok;

    // Query untuk memperbarui stok Menu di database
    $queryUpdateStok = "UPDATE menu SET NamaMenu='$NamaMenu', Harga='$Harga', Stok = '$stokBaru' WHERE MenuID = $MenuID";
    mysqli_query($conn, $queryUpdateStok);

    // Redirect ke halaman data_barang.php dengan pesan sukses
    header("location:data_barang.php?pesan=update_stok_sukses");
} else {
    // Jika Menu tidak ditemukan, redirect ke halaman data_barang.php dengan pesan error
    header("location:data_barang.php?pesan=Menu_tidak_ditemukan");
}

?>
