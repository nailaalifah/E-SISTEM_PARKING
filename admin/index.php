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

// PENDAPATAN GLOBAL HARI INI (Hanya menghitung transaksi yang SELESAI/KELUAR hari ini)
$q_pendapatan = mysqli_query($koneksi, "
    SELECT SUM(total_bayar) as total 
    FROM t_parkir 
    WHERE status = 'keluar' AND DATE(waktu_keluar) = CURDATE()
");
$pendapatan = mysqli_fetch_assoc($q_pendapatan);
$total_pendapatan = $pendapatan['total'] ?? 0;

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
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
    body { margin: 0; font-family: Arial; background: #f5f5f5; }
    .cards { display: flex; gap: 20px; padding: 20px; flex-wrap: wrap; }
    .card { flex: 1; min-width: 280px; background: #F2EDC2; padding: 20px; border-radius: 15px; position: relative; box-shadow: 0 5px 10px rgba(0,0,0,0.15); }
    .card-icon { position: absolute; top: 15px; right: 15px; font-size: 22px; background: #FFDE42; padding: 8px; border-radius: 8px; }
    
    /* Style Sekat Pembagi di Dalam Card */
    .sekat-container { display: flex; justify-content: space-around; margin-top: 15px; border-top: 2px dashed #d1cc9e; padding-top: 15px; }
    .sekat-item { text-align: center; flex: 1; }
    .sekat-item:not(:last-child) { border-right: 1px solid #d1cc9e; }
    .sekat-title { font-size: 13px; color: #555; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
    
    .card .angka { font-size: 28px; color: orange; font-weight: bold; }
    .table-container { padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    th { background: #346739; color: white; padding: 10px; }
    td { padding: 10px; text-align: center; border: 1px solid #ddd; }
    tr:nth-child(even) { background: #eee; }
    .status-masuk { background: orange; padding: 5px 10px; border-radius: 10px; color: black; font-weight: bold; }
    .status-keluar { background: red; color: white; padding: 5px 10px; border-radius: 10px; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

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
        <i class="bi bi-clock-history card-icon"></i>
        <h3 style="text-align: left; margin-right: 40px; font-size: 16px;">Kendaraan Masih Parkir</h3>
        
        <div class="sekat-container">
            <?php 
            mysqli_data_seek($q_statis, 0); 
            while($row_statis = mysqli_fetch_assoc($q_statis)){ 
            ?>
                <div class="sekat-item">
                    <div class="sekat-title"><?= $row_statis['nama_jenis'] ?></div>
                    <div class="angka" style="color: #2D3E1A;"><?= $row_statis['masih_parkir'] ?></div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <i class="bi bi-cash-stack card-icon"></i>
        <h3 style="font-size: 16px; margin-bottom: 15px;">Total Pendapatan (Hari Ini)</h3>
        <div class="angka" style="font-size: 32px; color: #346739;">Rp <?= number_format($total_pendapatan,0,',','.') ?></div>
    </div>

</div>

<div class="table-container">
    <h3>Riwayat Transaksi Aktif & Hari Ini</h3>
    <p style="margin-top: -10px; font-size: 14px; color: #666;">Menampilkan kendaraan aktif (termasuk menginap) dan transaksi selesai hari ini.</p>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Kode Tiket</th>
            <th>Plat</th>
            <th>Jenis</th>
            <th>Waktu Masuk</th>
            <th>Waktu Keluar</th>
            <th>Status</th>
        </tr>

        <?php if(mysqli_num_rows($data) > 0){ ?>
            <?php while($row = mysqli_fetch_assoc($data)){ ?>
            <tr>
                <td><?= $row['id_parkir'] ?></td>
                <td><?= $row['kode_tiket'] ?></td>
                <td><?= $row['plat_nomor'] ?></td>
                <td><?= !empty($row['nama_jenis']) ? $row['nama_jenis'] : 'Self-Service' ?></td>
                <td><?= $row['waktu_masuk'] ?></td>
                <td><?= ($row['status'] == 'keluar' && !empty($row['waktu_keluar'])) ? $row['waktu_keluar'] : '-' ?></td>
                <td>
                    <?php if($row['status'] == 'masuk'){ ?>
                        <span class="status-masuk">Parkir</span>
                    <?php } else { ?>
                        <span class="status-keluar">Keluar</span>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7">Belum ada data transaksi aktif.</td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>