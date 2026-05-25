<?php
session_start();
include '../koneksi.php';

// TAMBAHKAN BARIS INI UNTUK SETTING WAKTU INDONESIA (WIB)
date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['konfirmasi'])) {
    $id_parkir = $_POST['id_parkir'];
    $total_bayar = (int)$_POST['total_bayar']; // Ini tarif awal yang dikirim dari form
    $metode = $_POST['metode_pembayaran'];  
    $jumlah_bayar = (int)$_POST['jumlah_bayar'];
    
    // Sekarang $waktu_keluar akan mengikuti jam WIB (Jakarta)
    $waktu_keluar = date('Y-m-d H:i:s');

    // =========================================================================
    // LOGIKA REVISI: TARIF KELIPATAN HARI (MENGINAP)
    // =========================================================================
    // 1. Ambil waktu masuk dan jenis kendaraan untuk tahu tarif dasarnya
    $q_parkir = mysqli_query($koneksi, "
        SELECT p.waktu_masuk, j.tarif 
        FROM t_parkir p
        LEFT JOIN t_jenis_kendaraan j ON p.id_jenis = j.id_jenis
        WHERE p.id_parkir = '$id_parkir'
    ");
    $data_parkir = mysqli_fetch_assoc($q_parkir);
    
    $waktu_masuk = $data_parkir['waktu_masuk'];
    $tarif_dasar = (int)$data_parkir['tarif']; // Misalnya Motor = 2000

    // 2. Hitung selisih hari antara tanggal masuk dan tanggal keluar
    $tgl_masuk = new DateTime(date('Y-m-d', strtotime($waktu_masuk)));
    $tgl_keluar = new DateTime(date('Y-m-d', strtotime($waktu_keluar)));
    $selisih = $tgl_masuk->diff($tgl_keluar);
    $jumlah_hari_menginap = $selisih->days; // Ambil jumlah hari (0, 1, 2, dst)

    // 3. Jika menginap (lebih dari 0 hari), tarifnya diakumulasikan kelipatan hari
    $tambahan_biaya_menginap = 0;
    if ($jumlah_hari_menginap > 0) {
        // Rumus: Jumlah hari dikali tarif dasar kendaraannya (Motor 2000, Mobil beda lagi secara otomatis)
        $tambahan_biaya_menginap = $jumlah_hari_menginap * $tarif_dasar;
        
        // Tambahkan ke total bayar
        $total_bayar += $tambahan_biaya_menginap;
    }
    // =========================================================================

    // Hitung kembalian berdasarkan total_bayar yang sudah diperbarui
    $kembalian = $jumlah_bayar - $total_bayar;

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
        if ($jumlah_hari_menginap > 0) {
            echo "<script>alert('Pembayaran Berhasil! Kendaraan menginap $jumlah_hari_menginap hari. Tambahan biaya harian: Rp " . number_format($tambahan_biaya_menginap, 0, ',', '.') . "'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Pembayaran Berhasil!'); window.location='index.php';</script>";
        }
    }
}
?>