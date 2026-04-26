<?php
include '../koneksi.php';

if(isset($_POST['submit'])){
    $plat = strtoupper($_POST['plat_nomor']);
    $id_jenis = $_POST['id_jenis'];
    $waktu_masuk = date('Y-m-d H:i:s');
    
    // Generate Kode Tiket Otomatis (Contoh: PKR001)
    $query_max = mysqli_query($koneksi, "SELECT max(id_parkir) as maxID FROM t_parkir");
    $data_max = mysqli_fetch_array($query_max);
    $id_baru = $data_max['maxID'] + 1;
    $kode_tiket = "PKR" . str_pad($id_baru, 4, "0", STR_PAD_LEFT);

    // Simpan ke t_parkir (id_user kosongkan dulu karena belum diproses petugas)
    $insert = mysqli_query($koneksi, "INSERT INTO t_parkir (kode_tiket, plat_nomor, id_jenis, waktu_masuk, status) 
               VALUES ('$kode_tiket', '$plat', '$id_jenis', '$waktu_masuk', 'masuk')");

    if($insert){
        header("location:ambil_tiket.php?id=".$id_baru);
    }
}
?>