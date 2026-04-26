<?php
    include '../koneksi.php';
    $nama = $_POST['nama'];
    $tarif = $_POST['tarif'];
    $kapasitas = $_POST['kapasitas'];
    mysqli_query($koneksi, "insert into t_jenis_kendaraan values('','$nama', '$tarif','$kapasitas')");
    header("location:jenis_kendaraan.php");
?>