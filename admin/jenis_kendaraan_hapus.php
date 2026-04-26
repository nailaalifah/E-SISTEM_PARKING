<?php
    include '../koneksi.php';
    $id = $_GET['id'];
    mysqli_query($koneksi, "delete from t_jenis_kendaraan where id_jenis='$id'");
    
    echo "<script>alert('Data akan dihapus?'); window.location.href='jenis_kendaraan.php'</script>";
?>