<?php
    include '../koneksi.php';

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tarif = $_POST['tarif'];
    $kapasitas = $_POST['kapasitas'];

    mysqli_query($koneksi, "update t_jenis_kendaraan set nama_jenis='$nama', tarif='$tarif', kapasitas='$kapasitas' where id_jenis='$id'");

    echo "<script>alert('Data Telah Diubah'); window.location.href='jenis_kendaraan.php'</script>";
?>