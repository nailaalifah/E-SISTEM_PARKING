<?php
include '../koneksi.php';

// FILTER
$jenis   = isset($_GET['jenis']) ? $_GET['jenis'] : 'harian';
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
$bulan   = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun   = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Array bantuan untuk mengubah angka bulan menjadi teks nama bulan (Bahasa Indonesia)
$nama_bulan = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];

// QUERY
if ($jenis == 'harian') {
    $q = mysqli_query($koneksi, "
        SELECT p.*, u.nama 
        FROM t_parkir p
        JOIN t_user u ON p.id_user = u.id_user
        WHERE DATE(p.waktu_masuk) = '$tanggal'
        ORDER BY p.waktu_masuk DESC
    ");
} else {
    $q = mysqli_query($koneksi, "
        SELECT p.*, u.nama 
        FROM t_parkir p
        JOIN t_user u ON p.id_user = u.id_user
        WHERE MONTH(p.waktu_masuk) = '$bulan'
        AND YEAR(p.waktu_masuk) = '$tahun'
        ORDER BY p.waktu_masuk DESC
    ");
}

// HITUNG
$total_kendaraan = mysqli_num_rows($q);
$total_pendapatan = 0;
$data = [];
while ($d = mysqli_fetch_assoc($q)) {
    $data[] = $d;
    $total_pendapatan += (int)$d['total_bayar'];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - E-Parking System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #ffffff;
            min-height: 100vh;
        }

        :root {
            --sidebar-green: #346739;
            --sidebar-light: #79AE6F;
            --active-yellow: #FFDE42;
            --table-header: #4D5D30;
            --table-row-even: #A2C18E;
            --table-row-odd: #87A971;
            --card1: #7ea567;
            --card2: #3d6b3a;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(to bottom, var(--sidebar-green), var(--sidebar-light));
            color: white;
            padding-top: 20px;
            z-index: 100;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a.active {
            background: var(--active-yellow);
            color: black;
            border-radius: 25px 0 0 25px;
            margin-left: 10px;
            font-weight: bold;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 220px;
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            background: linear-gradient(to right, #FFDE42, #ffffff);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .header-title {
            font-size: 26px;
            font-weight: bold;
        }

        .header-logo {
            width: 50px;
        }

        /* FILTER */
        .filter {
            background: #fff3a0;
            margin: 20px 30px;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter select,
        .filter input {
            padding: 8px;
            border-radius: 5px;
            border: none;
        }

        .btn {
            background: var(--sidebar-green);
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-print {
            background: #ddd;
            color: black;
        }

        /* CARD */
        .cards {
            margin: 20px 30px;
        }

        .card {
            display: inline-block;
            width: 220px;
            padding: 15px;
            border-radius: 10px;
            color: white;
            margin-right: 10px;
        }

        .card1 { background: var(--card1); }
        .card2 { background: var(--card2); }
        .card h3 { font-size: 14px; margin-bottom: 5px; }
        .card h2 { font-size: 22px; }

        /* TABEL CONTAINER */
        .table-box {
            background: #fff3a0;
            margin: 20px 30px;
            padding: 15px;
            border-radius: 10px;
        }

        .table-box h3 {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background: var(--table-header);
            color: white;
            padding: 12px;
            text-transform: uppercase;
            font-size: 13px;
        }

        td {
            padding: 10px;
            font-size: 14px;
        }

        tr:nth-child(odd) td { background: var(--table-row-odd); }
        tr:nth-child(even) td { background: var(--table-row-even); }

        .status {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }
        .keluar { background: #e74c3c; }
        .masuk { background: #2ecc71; }

        /* Teks Keterangan Periode (Hanya Muncul Saat Di-print) */
        .print-period-title {
            display: none;
            font-size: 16px;
            font-weight: 600;
            margin: -10px 0 20px 0;
            color: #333;
        }

        /* ==========================================
           REVISI: STYLING KHUSUS SAAT HALAMAN DI-PRINT 
           ========================================== */
        @media print {
            body {
                background: white;
                color: black;
            }

            /* 1. Sembunyikan Sidebar navigasi kiri */
            .sidebar {
                display: none !important;
            }

            /* 2. Geser konten utama ke pojok kiri penuh (menghilangkan sisa space sidebar) */
            .main {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            /* 3. Sembunyikan Form Filter pencarian & tombol cetak */
            .filter {
                display: none !important;
            }

            /* 4. Sembunyikan dekorasi Header gradasi kuning (opsional, agar kertas print bersih) */
            .header {
                box-shadow: none !important;
                border-bottom: 2px solid #333;
                padding: 10px 0 !important;
                margin-bottom: 15px !important;
                background: transparent !important;
            }
            
            .header-title {
                font-size: 24px !important;
            }

            /* 5. Tampilkan keterangan waktu periode pencarian di bawah judul */
            .print-period-title {
                display: block !important;
            }

            /* 6. Hilangkan margin luar bawaan layout web agar pas di kertas */
            .cards, .table-box {
                margin: 20px 0 !important;
                padding: 0 !important;
                background: transparent !important;
            }

            /* 7. Konfigurasi warna tabel agar tetap terbaca jelas di cetakan fisik */
            table {
                border: 1px solid #333;
            }
            th {
                background: #4A5D2C !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            tr:nth-child(odd) td {
                background: #f2f2f2 !important; /* Warna abu-abu soft agar menghemat tinta printer */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            tr:nth-child(even) td {
                background: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            /* Sembunyikan badge warna status jika dirasa terlalu tebal saat diprint */
            .status {
                color: black !important;
                padding: 0 !important;
                font-weight: normal;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>E-Parking<br>System</h2>
        <a href="index.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="data_user.php"><i class="bi bi-people"></i> Data User</a>
        <a href="jenis_kendaraan.php"><i class="bi bi-bicycle"></i> Jenis Kendaraan</a>
        <a href="pembayaran.php"><i class="bi bi-cash"></i> Pembayaran</a>
        <a href="laporan.php" class="active"><i class="bi bi-file-earmark-text"></i> Laporan</a>
        <a href="../logout.php" style="margin-top:50px;"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="main">

        <div class="header">
            <div class="header-title">Data Laporan</div>
            <img src="../logo.png" class="header-logo">
        </div>

        <div class="container">
            <div class="print-period-title">
                Periode Laporan: 
                <?php 
                if ($jenis == 'harian') {
                    echo date('d ', strtotime($tanggal)) . $nama_bulan[date('m', strtotime($tanggal))] . date(' Y', strtotime($tanggal));
                } else {
                    echo $nama_bulan[sprintf("%02d", $bulan)] . " " . $tahun;
                }
                ?>
            </div>
        </div>

        <form class="filter" method="GET">
            Jenis:
            <select name="jenis" onchange="this.form.submit()">
                <option value="harian" <?= $jenis == 'harian' ? 'selected' : '' ?>>Harian</option>
                <option value="bulanan" <?= $jenis == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
            </select>

            <?php if ($jenis == 'harian') { ?>
                Tanggal:
                <input type="date" name="tanggal" value="<?= $tanggal ?>">
            <?php } else { ?>
                Bulan:
                <input type="number" name="bulan" value="<?= $bulan ?>" min="1" max="12">
                Tahun:
                <input type="number" name="tahun" value="<?= $tahun ?>">
            <?php } ?>

            <button class="btn">Filter</button>
            <button type="button" onclick="window.print()" class="btn btn-print">
                <i class="bi bi-printer"></i> Print
            </button>
        </form>

        <div class="cards">
            <div class="card card1">
                <h3>Total Kendaraan</h3>
                <h2><?= $total_kendaraan ?></h2>
            </div>

            <div class="card card2">
                <h3>Total Pendapatan</h3>
                <h2>Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h2>
            </div>
        </div>

        <div class="table-box">
            <h3>Data Parkir</h3>

            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Plat</th>
                        <th>Jenis</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Petugas</th>
                        <th>Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $d) { ?>
                        <tr>
                            <td><?= $d['kode_tiket'] ?></td>
                            <td><?= $d['plat_nomor'] ?></td>
                            <td><?= $d['id_jenis'] ?></td>
                            <td><?= $d['waktu_masuk'] ?></td>
                            <td><?= $d['waktu_keluar'] ?></td>
                            <td><?= $d['nama'] ?></td>
                            <td>Rp <?= number_format($d['total_bayar'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($d['waktu_keluar']) { ?>
                                    <span class="status keluar">Keluar</span>
                                <?php } else { ?>
                                    <span class="status masuk">Masuk</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>