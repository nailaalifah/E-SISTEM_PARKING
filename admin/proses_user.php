<?php
include 'koneksi.php';

// TAMBAH
if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    mysqli_query($koneksi, "INSERT INTO users 
    VALUES ('','$nama','$username','$password','$role')");
}

// EDIT
if(isset($_POST['update'])){
    $id = $_POST['id_user'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    mysqli_query($koneksi, "UPDATE users SET
        nama='$nama',
        username='$username',
        password='$password',
        role='$role'
        WHERE id_user='$id'
    ");
}

header("location:data_user.php");