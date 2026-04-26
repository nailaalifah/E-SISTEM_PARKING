<?php
session_start();
include '../koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Scan Keluar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body { background: #f5f5f5; font-family: Arial; margin: 0; }
        .header { background: #FFDE42; padding: 15px; display: flex; align-items: center; }
        .scan-area { background: #79AE6F; border-radius: 15px; padding: 20px; text-align: center; margin: 20px; }
        /* Area Kamera */
        #reader { width: 100%; max-width: 450px; margin: 0 auto; background: #d9ead3; border-radius: 15px; overflow: hidden; border: none !important; }
        .manual-area { background: #79AE6F; border-radius: 15px; padding: 25px; margin: 20px; }
        .input-group-custom { background: white; border-radius: 30px; display: flex; align-items: center; padding: 5px 20px; }
        .input-group-custom input { border: none; flex: 1; padding: 10px; outline: none; }
        .divider { text-align: center; margin: 15px 0; font-weight: bold; }
    </style>
</head>
<body>

<div class="header">
    <a href="index.php" style="text-decoration:none; color:black; font-size:24px; margin-right:20px;"><i class="bi bi-arrow-left"></i></a>
    <h2 class="m-0">Scan Keluar</h2>
</div>

<div class="scan-area">
    <div id="reader"></div>
    <div id="result"></div>
    <div class="mt-3">
        <button class="btn btn-light rounded-pill px-4" onclick="mulaiScan()">
            <i class="bi bi-camera"></i> Aktifkan Kamera
        </button>
    </div>
</div>

<div class="divider">ATAU</div>

<div class="manual-area">
    <h5 class="text-white mb-3" style="font-weight: bold;">Masukkan Kode Tiket</h5>
    <form action="konfirmasi_keluar.php" method="GET">
        <div class="input-group-custom shadow-sm">
            <input type="text" name="kode_tiket" placeholder="Masukkan kode tiket" required>
            <button type="submit" style="border:none; background:none;"><i class="bi bi-search"></i></button>
        </div>
    </form>
    <p class="text-white mt-3 mb-0" style="font-size: 14px;">Scan QR atau masukkan kode tiket untuk keluar.</p>
</div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Jika scan berhasil, arahkan ke halaman konfirmasi
        window.location.href = "konfirmasi_keluar.php?kode_tiket=" + decodedText;
        html5QrcodeScanner.clear(); // Matikan kamera setelah berhasil
    }

    function mulaiScan() {
        const html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        // Minta akses kamera
        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
        .catch(err => {
            alert("Gagal akses kamera! Pastikan izin kamera sudah diberikan.");
            console.error(err);
        });
    }
</script>

</body>
</html>