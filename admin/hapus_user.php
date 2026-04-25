<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id'");

header("location:data_user.php");