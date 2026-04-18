<?php
include '../koneksi.php';
$id = $_GET['id'];

// Ambil data lengkap dengan JOIN jenis kendaraan
$query = mysqli_query($koneksi, "SELECT t_parkir.*, t_jenis_kendaraan.Nama_Jenis 
                                 FROM t_parkir 
                                 JOIN t_jenis_kendaraan ON t_parkir.id_jenis = t_jenis_kendaraan.Id_Jenis 
                                 WHERE Id_Parkir='$id'");
$d = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Masuk - <?= $d['kode_tiket'] ?></title>
    <style>
        body { font-family: 'Courier New', monospace; background: #79AE6F; display: flex; justify-content: center; padding-top: 50px; }
        .struk { background: white; width: 350px; padding: 20px; border-radius: 15px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        .qr { margin: 20px 0; }
        .line { border-top: 2px dashed #000; margin: 10px 0; }
        .detail { text-align: left; font-size: 14px; margin-bottom: 5px; }
        .row-detail { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .footer { font-size: 12px; margin-top: 20px; font-style: italic; }
        @media print { body { background: none; padding: 0; } .btn-print { display: none; } }
        .btn-group { position: fixed; right: 20px; bottom: 20px; }
        .btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; }
        .btn-cetak { background: #F2EDC2; }
    </style>
</head>
<body>

    <div class="struk">
        <h3>E-Parking System</h3>
        
        <div class="qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $d['qr_code'] ?>" alt="QR">
        </div>

        <div class="line"></div>
        
        <div class="row-detail">
            <span>Kode Tiket :</span>
            <span><strong><?= $d['kode_tiket'] ?></strong></span>
        </div>
        <div class="row-detail">
            <span>Jenis Kendaraan :</span>
            <span><?= $d['Nama_Jenis'] ?></span>
        </div>
        <div class="row-detail">
            <span>Plat Nomor :</span>
            <span><strong><?= $d['plat_nomor'] ?></strong></span>
        </div>
        <div class="row-detail">
            <span>Waktu Masuk :</span>
            <span><?= date('d/m/Y H:i:s', strtotime($d['waktu_masuk'])) ?></span>
        </div>

        <div class="line"></div>
        <div class="footer">
            Jika struk hilang kendaraan bukan<br>tanggung jawab kami
        </div>
    </div>

    <div class="btn-group">
        <button onclick="window.print()" class="btn btn-cetak">Cetak Struk</button>
    </div>

</body>
</html>