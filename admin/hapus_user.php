<?php
include '../koneksi.php';

// ambil id dari URL
$id = $_GET['id'];

// hapus data dari database
mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id'");

// kembali ke halaman data user
header("location:data_user.php");
?>