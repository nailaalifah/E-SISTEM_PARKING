<?php
session_start();
include '../koneksi.php';

// Ambil ID Parkir dari URL
$id_parkir = $_GET['id']; 

// Query gabungan 4 tabel sesuai database kamu (huruf kecil semua)
// t_parkir, t_jenis_kendaraan, t_user, t_pembayaran
$query = mysqli_query($koneksi, "SELECT * FROM t_parkir 
    JOIN t_jenis_kendaraan ON t_parkir.id_jenis = t_jenis_kendaraan.id_jenis
    JOIN t_user ON t_parkir.id_user = t_user.id_user
    JOIN t_pembayaran ON t_parkir.id_parkir = t_pembayaran.id_parkir
    WHERE t_parkir.id_parkir = '$id_parkir'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Struk Keluar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #79AE6F; font-family: 'Courier New', Courier, monospace; }
        .container-struk { max-width: 500px; margin: 40px auto; padding: 20px; position: relative; }
        .back-btn { position: absolute; top: 0; left: -50px; color: black; font-size: 28px; text-decoration: none; }
        .struk-white { 
            background: white; 
            border-radius: 15px; 
            padding: 25px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .line-dashed { border-top: 2px dashed #000; margin: 15px 0; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 15px; font-weight: bold; }
        .btn-print { 
            background: #F2EDC2; 
            border: none; 
            color: black; 
            padding: 10px 30px; 
            border-radius: 10px; 
            font-weight: bold; 
            margin-top: 20px;
        }
        @media print {
            .btn-print, .back-btn { display: none; }
            body { background: white; }
            .container-struk { margin: 0; padding: 0; }
            .struk-white { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>

<div class="container-struk">
    <a href="index.php" class="back-btn"><i class="bi bi-arrow-left"></i></a>

    <div class="struk-white">
        <div class="text-center">
            <h4 class="fw-bold mb-1">E-Parking System</h4>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $data['kode_tiket']; ?>" class="my-3">
            <div class="fw-bold">==================================</div>
        </div>

        <div class="mt-3">
            <div class="info-row"><span>Kode Tiket :</span> <span><?= $data['kode_tiket']; ?></span></div>
            <div class="info-row"><span>Jenis Kendaraan :</span> <span><?= $data['nama_jenis']; ?></span></div>
            <div class="info-row"><span>Plat Nomor :</span> <span><?= $data['plat_nomor']; ?></span></div>
            <div class="info-row"><span>Waktu Masuk :</span> <span><?= $data['waktu_masuk']; ?></span></div>
            <div class="info-row"><span>Waktu Keluar :</span> <span><?= $data['waktu_keluar']; ?></span></div>
            <div class="info-row"><span>Petugas :</span> <span><?= $data['nama']; ?></span></div>
            <div class="info-row"><span>Jenis Transaksi :</span> <span><?= $data['metode_pembayaran']; ?></span></div>
            
            <div class="line-dashed"></div>
            
            <div class="info-row"><span>Total :</span> <span><?= number_format($data['total_bayar']); ?></span></div>
            <div class="info-row"><span>Bayar :</span> <span><?= number_format($data['jumlah_bayar']); ?></span></div>
            <div class="info-row"><span>Kembali :</span> <span><?= number_format($data['kembalian']); ?></span></div>
            
            <div class="line-dashed"></div>
            
            <div class="text-center fw-bold mt-3">
                Terimakasih<br>
                hati - hati di jalan
            </div>
        </div>
    </div>

    <div class="text-end">
        <button onclick="window.print()" class="btn-print shadow-sm">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </div>
</div>

</body>
</html>