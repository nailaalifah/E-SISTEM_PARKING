<?php 
session_start();
include '../koneksi.php';

// SETTING WAKTU INDONESIA (WIB)
date_default_timezone_set('Asia/Jakarta');

// =========================================================================
// QUERY PERBAIKAN TOTAL: Statistik Dinamis (Akurat & Mendukung Menginap)
// =========================================================================
$q_statis = mysqli_query($koneksi, "
    SELECT 
        j.id_jenis,
        j.nama_jenis, 
        j.kapasitas,
        COUNT(CASE WHEN DATE(p.waktu_masuk) = CURDATE() THEN 1 END) as total_hari_ini,
        COUNT(CASE WHEN p.status = 'masuk' THEN 1 END) as masih_parkir
    FROM t_jenis_kendaraan j
    LEFT JOIN t_parkir p ON j.id_jenis = p.id_jenis
    GROUP BY j.id_jenis
");

// DATA TABEL RIWAYAT: Hanya kendaraan masuk hari ini ATAU kendaraan lama yang masih parkir
$data = mysqli_query($koneksi, "
    SELECT p.*, j.nama_jenis 
    FROM t_parkir p 
    LEFT JOIN t_jenis_kendaraan j ON p.id_jenis = j.id_jenis 
    WHERE DATE(p.waktu_masuk) = CURDATE() 
    OR p.status = 'masuk'
    ORDER BY p.id_parkir DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Petugas</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body { margin: 0; font-family: Arial; background: #f5f5f5; }
.top-action { display: flex; justify-content: space-between; padding: 20px; }
.btn { background: #79AE6F; padding: 10px 20px; border-radius: 20px; color: white; text-decoration: none; }
.cards { display: flex; gap: 20px; padding: 20px; flex-wrap: wrap; }
.card { flex: 1; min-width: 280px; background: #F2EDC2; padding: 20px; border-radius: 15px; text-align: center; position: relative; box-shadow: 0 5px 10px rgba(0,0,0,0.15); }
.card-icon { position: absolute; right: 15px; top: 15px; background: #FFDE42; padding: 8px; border-radius: 8px; font-size: 20px; }

/* Style Sekat Pembagi di Dalam Card Petugas */
.sekat-container { display: flex; justify-content: space-around; margin-top: 15px; border-top: 2px dashed #d1cc9e; padding-top: 15px; }
.sekat-item { text-align: center; flex: 1; }
.sekat-item:not(:last-child) { border-right: 1px solid #d1cc9e; }
.sekat-title { font-size: 13px; color: #555; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }

.angka { font-size: 28px; color: orange; font-weight: bold; }
.table-container { padding: 20px; }
table { width: 100%; border-collapse: collapse; }
th { background: #346739; color: white; padding: 10px; }
td { padding: 10px; text-align: center; border: 1px solid #ddd; }
tr:nth-child(even) { background: #eee; }
.status-masuk { background: orange; padding: 5px 10px; border-radius: 10px; color: black; font-weight: bold; }
.status-keluar { background: red; color: white; padding: 5px 10px; border-radius: 10px; }
.btn-sm { padding: 5px 10px; border-radius: 6px; text-decoration: none; color: white; font-size: 12px; }
.btn-edit { background: #17a2b8; }
.btn-print { background: #28a745; }
.btn-final { background: #6c757d; }
</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="top-action">
    <a href="transaksi_masuk.php" class="btn">
        <i class="bi bi-plus-circle"></i> Transaksi Masuk
    </a>
    <a href="scan_keluar.php" class="btn">
        <i class="bi bi-camera"></i> Scan Keluar
    </a>
</div>

<div class="cards">
    
    <div class="card">
        <i class="bi bi-bicycle card-icon"></i>
        <h3 style="text-align: left; margin-right: 40px; font-size: 16px;">Total Kendaraan Hari Ini</h3>
        <div class="sekat-container">
            <?php 
            mysqli_data_seek($q_statis, 0); 
            while($row_statis = mysqli_fetch_assoc($q_statis)){ 
            ?>
                <div class="sekat-item">
                    <div class="sekat-title"><?= $row_statis['nama_jenis'] ?></div>
                    <div class="angka"><?= $row_statis['total_hari_ini'] ?></div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card">
        <i class="bi bi-clock history card-icon"></i>
        <h3 style="text-align: left; margin-right: 40px; font-size: 16px;">Kendaraan Masih Parkir</h3>
        <div class="sekat-container">
            <?php 
            mysqli_data_seek($q_statis, 0); 
            while($row_statis = mysqli_fetch_assoc($q_statis)){ 
            ?>
                <div class="sekat-item">
                    <div class="sekat-title"><?= $row_statis['nama_jenis'] ?></div>
                    <div class="angka" style="color: #c47d00;"><?= $row_statis['masih_parkir'] ?></div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card">
        <i class="bi bi-archive card-icon"></i>
        <h3 style="text-align: left; margin-right: 40px; font-size: 16px;">Sisa Kapasitas</h3>
        <div class="sekat-container">
            <?php 
            mysqli_data_seek($q_statis, 0); 
            while($row_statis = mysqli_fetch_assoc($q_statis)){ 
                $sisa = (int)$row_statis['kapasitas'] - (int)$row_statis['masih_parkir'];
            ?>
                <div class="sekat-item">
                    <div class="sekat-title"><?= $row_statis['nama_jenis'] ?></div>
                    <div class="angka" style="color: <?= $sisa <= 0 ? 'red' : '#346739' ?>;">
                        <?= $sisa <= 0 ? 'Full' : $sisa ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="table-container">
    <h3>Riwayat Transaksi Aktif & Hari Ini</h3>
    <p style="margin-top: -10px; font-size: 14px; color: #666;">Monitoring tiket parkir aktif dan yang selesai diproses hari ini.</p>

    <table>
        <tr>
            <th>No</th>
            <th>Plat Nomor</th>
            <th>Jenis</th>
            <th>Waktu Masuk</th>
            <th>Status</th>
            <th>Opsi</th>
        </tr>

        <?php 
        $no = 1;
        if(mysqli_num_rows($data) > 0) {
            while($row = mysqli_fetch_assoc($data)){ ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['plat_nomor']; ?></td>
                <td><?= !empty($row['nama_jenis']) ? $row['nama_jenis'] : 'Self-Service' ?></td>
                <td><?= $row['waktu_masuk']; ?></td>
                <td>
                    <?php if($row['status'] == 'masuk'){ ?>
                        <span class="status-masuk">Parkir</span>
                    <?php } else { ?>
                        <span class="status-keluar">Keluar</span>
                    <?php } ?>
                </td>
                <td>
                    <?php if($row['status'] == 'masuk'){ ?>
                        <a href="edit_transaksi.php?id=<?= $row['id_parkir'] ?>" class="btn-sm btn-edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="ambil_tiket.php?id=<?= $row['id_parkir'] ?>" target="_blank" class="btn-sm btn-print">
                            <i class="bi bi-printer"></i> Cetak
                        </a>
                    <?php } else { ?>
                        <a href="ambil_tiket_keluar.php?id=<?= $row['id_parkir'] ?>" target="_blank" class="btn-sm btn-final">
                            <i class="bi bi-printer"></i> Print
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <?php } 
        } else { ?>
            <tr>
                <td colspan="6">Belum ada data transaksi aktif.</td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>