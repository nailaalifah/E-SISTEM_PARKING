<?php
session_start();
include '../koneksi.php';

if (isset($_POST['konfirmasi'])) {
    $id_parkir = $_POST['id_parkir'];
    $total_bayar = $_POST['total_bayar'];
    $metode = $_POST['metode_pembayaran'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $kembalian = $jumlah_bayar - $total_bayar;
    $waktu_keluar = date('Y-m-d H:i:s');

    // 1. Update tabel t_parkir
    $upd = mysqli_query($koneksi, "UPDATE t_parkir SET 
            waktu_keluar = '$waktu_keluar',
            total_bayar = '$total_bayar',
            status = 'keluar'
            WHERE id_parkir = '$id_parkir'");

    // 2. Insert ke tabel t_pembayaran
    $ins = mysqli_query($koneksi, "INSERT INTO t_pembayaran 
            (id_parkir, metode_pembayaran, jumlah_bayar, kembalian, waktu_bayar) 
            VALUES 
            ('$id_parkir', '$metode', '$jumlah_bayar', '$kembalian', '$waktu_keluar')");

    if ($upd && $ins) {
        echo "<script>alert('Pembayaran Berhasil!'); window.location='index.php';</script>";
        // Nanti di sini kita arahkan ke cetak_struk_keluar.php
    }
}