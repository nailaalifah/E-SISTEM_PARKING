<?php
session_start();
include '../koneksi.php';

$kode = isset($_GET['kode_tiket']) ? $_GET['kode_tiket'] : '';

// Ambil data parkir berdasarkan kode_tiket atau qr_code
$query = mysqli_query($koneksi, "SELECT p.*, j.nama_jenis, j.tarif 
                                 FROM t_parkir p 
                                 JOIN t_jenis_kendaraan j ON p.id_jenis = j.id_jenis 
                                 WHERE p.kode_tiket = '$kode' OR p.qr_code = '$kode'");
$d = mysqli_fetch_assoc($query);

if (!$d) {
    echo "<script>alert('Tiket tidak ditemukan!'); window.location='scan_keluar.php';</script>";
    exit;
}

if ($d['status'] == 'keluar') {
    echo "<script>alert('Kendaraan ini sudah melakukan pembayaran!'); window.location='index.php';</script>";
    exit;
}

// Hitung Durasi & Total
$waktu_masuk = new DateTime($d['waktu_masuk']);
$waktu_keluar = new DateTime(); // Tambahkan ini untuk menampilkan waktu saat ini
$total_bayar = (int)$d['tarif'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Keluar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f5f5f5; font-family: Arial; }
        .header { background: #FFDE42; padding: 15px; }
        .container-box { padding: 20px; }
        .form-area { background: #79AE6F; border-radius: 15px; padding: 25px; }
        .row-data { display: flex; align-items: center; margin-bottom: 12px; }
        .label-data { width: 150px; color: white; font-weight: bold; }
        .input-read { flex: 1; background: #F2EDC2; padding: 8px 15px; border-radius: 10px; border: none; }
        .input-edit { flex: 1; padding: 8px 15px; border-radius: 10px; border: none; }
        .btn-konfirmasi { width: 100%; background: #346739; color: white; padding: 12px; border-radius: 10px; border: none; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>

<div class="header">
    <h2 class="m-0">Scan Keluar</h2>
</div>

<div class="container-box">
    <div class="form-area">
        <form action="proses_pembayaran.php" method="POST">
            <input type="hidden" name="id_parkir" value="<?= $d['id_parkir'] ?>">
            <input type="hidden" name="total_bayar" value="<?= $total_bayar ?>">

            <div class="row-data">
                <div class="label-data">Kode Tiket :</div>
                <input type="text" class="input-read" value="<?= $d['kode_tiket'] ?>" readonly>
            </div>
            <div class="row-data">
                <div class="label-data">Jenis Kendaraan :</div>
                <input type="text" class="input-read" value="<?= $d['nama_jenis'] ?>" readonly>
            </div>
            <div class="row-data">
                <div class="label-data">Plat Nomor :</div>
                <input type="text" class="input-read" value="<?= $d['plat_nomor'] ?>" readonly>
            </div>
             <div class="row-data">
                <div class="label-data">Waktu Masuk :</div>
                <input type="text" class="input-read" value="<?= $d['waktu_masuk'] ?>" readonly>
            </div>
             <div class="row-data">
                <div class="label-data">Waktu Keluar :</div>
                <input type="text" class="input-read" value="<?= $waktu_keluar->format('Y-m-d H:i:s') ?>" readonly>
            </div>

            <div class="row-data">
                <div class="label-data">Jenis Transaksi :</div>
                <select name="metode_pembayaran" id="metode" class="input-edit" onchange="cekMetode()" required>
                    <option value="">Pilih metode pembayaran...</option>
                    <option value="Tunai">Tunai</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

            <div class="row-data">
                <div class="label-data">Total :</div>
                <input type="text" class="input-read" value="<?= number_format($total_bayar, 0, ',', '.') ?>" readonly>
            </div>

            <div class="row-data">
                <div class="label-data">Bayar :</div>
                <input type="number" name="jumlah_bayar" id="bayar" class="input-edit" placeholder="Masukkan jumlah pembayaran" oninput="hitungKembali()" required>
            </div>

            <div class="row-data">
                <div class="label-data">Kembali :</div>
                <input type="text" id="kembalian" class="input-read" value="0" readonly>
            </div>

            <button type="submit" name="konfirmasi" class="btn-konfirmasi">Konfirmasi Pembayaran & Keluar</button>
        </form>
    </div>
</div>

<script>
// Gabungkan semua fungsi di satu tempat agar rapi
function hitungKembali() {
    const total = parseInt("<?= $total_bayar ?>") || 0;
    const bayarInput = document.getElementById('bayar');
    const bayar = parseInt(bayarInput.value) || 0;
    
    const kembali = bayar - total;
    document.getElementById('kembalian').value = kembali > 0 ? kembali : 0;
}

function cekMetode() {
    const metode = document.getElementById('metode').value;
    const total = parseInt("<?= $total_bayar ?>") || 0;
    const inputBayar = document.getElementById('bayar');
    const inputKembali = document.getElementById('kembalian');

    if (metode === 'QRIS') {
        inputBayar.value = total;
        inputBayar.readOnly = true;
        inputKembali.value = 0;
    } else {
        inputBayar.value = '';
        inputBayar.readOnly = false;
        inputKembali.value = 0;
    }
}
</script>

</body>
</html>