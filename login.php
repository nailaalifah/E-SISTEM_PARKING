<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password']; 

$data = mysqli_query($koneksi, "SELECT * FROM t_user WHERE username='$username' AND password='$password'");

// debug kalau error
if(!$data){
    die("Error: " . mysqli_error($koneksi));
}

$cek = mysqli_num_rows($data);

if($cek > 0){

    $d = mysqli_fetch_assoc($data);

    $_SESSION['username'] = $d['username'];
    $_SESSION['status'] = $d['status'];

    if($d['role'] == 1){
        header("location:admin/index.php");
    }elseif($d['status'] == 2){
        header("location:petugas/index.php");
    }

}else{
    header("location:index.php?pesan=gagal");
}
?>