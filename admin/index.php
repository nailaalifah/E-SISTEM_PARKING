<?php 
session_start();
include '../koneksi.php';

// TOTAL HARI INI
$q_total = mysqli_query($koneksi, "
    SELECT COUNT(*) as total 
    FROM t_parkir 
    WHERE DATE(waktu_masuk)=CURDATE()
");
$total = mysqli_fetch_assoc($q_total);

// MASIH PARKIR
$q_parkir = mysqli_query($koneksi, "
    SELECT COUNT(*) as parkir 
    FROM t_parkir 
    WHERE waktu_keluar IS NULL
");
$parkir = mysqli_fetch_assoc($q_parkir);

// PENDAPATAN
$q_pendapatan = mysqli_query($koneksi, "
    SELECT SUM(total_bayar) as total 
    FROM t_parkir 
    WHERE DATE(waktu_masuk)=CURDATE()
");
$pendapatan = mysqli_fetch_assoc($q_pendapatan);
$total_pendapatan = $pendapatan['total'] ?? 0;

// DATA
$data = mysqli_query($koneksi, "
    SELECT p.*, j.nama_jenis 
    FROM t_parkir p
    LEFT JOIN t_jenis_kendaraan j 
    ON p.id_jenis = j.id_jenis
    ORDER BY p.id_parkir DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Dashboard</title>

    <!-- TAMBAHAN ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
    body {
        margin: 0;
        font-family: Arial;
        background: #f5f5f5;
    }

    /* TAMBAHAN ICON CARD */
    .card {
        position: relative;
    }

    .card-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 20px;
        background: #FFDE42;
        padding: 8px;
        border-radius: 8px;
    }

    .cards {
        display: flex;
        gap: 20px;
        padding: 20px;
    }

    .card {
        flex: 1;
        background: #F2EDC2;
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }

    .card .angka {
        font-size: 30px;
        color: orange;
    }

    .table-container {
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #346739;
        color: white;
        padding: 10px;
    }

    td {
        padding: 10px;
        text-align: center;
    }

    tr:nth-child(even) {
        background: #eee;
    }

    .status-masuk {
        background: orange;
        padding: 5px 10px;
        border-radius: 10px;
    }

    .status-keluar {
        background: red;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
    }
    </style>
</head>

<body>

<?php include 'header.php'; ?>

<!-- CARDS -->
<div class="cards">

    <div class="card">
        <i class="bi bi-bicycle card-icon"></i>
        <h3>Total Kendaraan Hari Ini</h3>
        <div class="angka"><?= $total['total'] ?></div>
    </div>

    <div class="card">
        <i class="bi bi-clock-history card-icon"></i>
        <h3>Kendaraan Masih Parkir</h3>
        <div class="angka"><?= $parkir['parkir'] ?></div>
    </div>

    <div class="card">
        <i class="bi bi-cash-stack card-icon"></i>
        <h3>Total Pendapatan</h3>
        <div class="angka">Rp <?= number_format($total_pendapatan,0,',','.') ?></div>
    </div>

</div>

<!-- TABLE -->
<div class="table-container">
    <h3>Riwayat Transaksi</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Kode Tiket</th>
            <th>Plat</th>
            <th>Jenis</th>
            <th>Waktu</th>
            <th>Status</th>
        </tr>

        <?php if(mysqli_num_rows($data) > 0){ ?>
            <?php while($row = mysqli_fetch_assoc($data)){ ?>
            <tr>
                <td><?= $row['id_parkir'] ?></td>
                <td><?= $row['kode_tiket'] ?></td>
                <td><?= $row['plat_nomor'] ?></td>
                <td><?= $row['nama_jenis'] ?></td>
                <td>
                    <?= $row['waktu_masuk'] ?> 
                    <?= $row['waktu_keluar'] ? "- ".$row['waktu_keluar'] : "" ?>
                </td>
                <td>
                    <?php if($row['waktu_keluar'] == NULL){ ?>
                        <span class="status-masuk">Parkir</span>
                    <?php } else { ?>
                        <span class="status-keluar">Keluar</span>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">Belum ada data transaksi</td>
            </tr>
        <?php } ?>

    </table>
</div>

</div>

</body>
</html>