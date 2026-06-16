<?php

session_start();

include 'conn.php';

//login
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $login = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username' and password='$password' ");
    $hitung = mysqli_num_rows($login);

    if($hitung > 0){

        $data = mysqli_fetch_assoc($login);

        if($data['level']=="1"){
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "1";
            header("location:admin/index.php");

        } else 
        
        if($data['level']=="2"){
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "2";
            header("location:petugas/index.php");
        } else{
            header("location:login.php?pesan=gagal");
        }
} else{
    header("location:login.php?pesan=gagal");
}


?>