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
    WHERE status='masuk'
");
$parkir = mysqli_fetch_assoc($q_parkir);

// KAPASITAS (ambil dari jenis kendaraan motor id=1)
$q_kapasitas = mysqli_query($koneksi, "
    SELECT kapasitas FROM t_jenis_kendaraan WHERE id_jenis=1
");
$kap = mysqli_fetch_assoc($q_kapasitas);

$sisa_kapasitas = $kap['kapasitas'] - $parkir['parkir'];

// DATA TABEL
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
<title>Dashboard Petugas</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f5f5f5;
}

/* BUTTON ATAS */
.top-action {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

.btn {
    background: #79AE6F;
    padding: 10px 20px;
    border-radius: 20px;
    color: white;
    text-decoration: none;
}

/* CARD */
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
    position: relative;
}

.card-icon {
    position: absolute;
    right: 15px;
    top: 15px;
    background: #FFDE42;
    padding: 8px;
    border-radius: 8px;
}

.angka {
    font-size: 30px;
    color: orange;
}

/* TABLE */
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

<!-- BUTTON -->
<div class="top-action">
    <a href="transaksi_masuk.php" class="btn"><i class="bi bi-plus-circle"></i> Transaksi Masuk</a>
    <a href="#" class="btn"><i class="bi bi-camera"></i> Scan Keluar</a>
</div>

<!-- CARD -->
<div class="cards">

<div class="card">
    <i class="bi bi-bicycle card-icon"></i>
    <h3>Total Kendaraan Hari Ini</h3>
    <div class="angka"><?= $total['total'] ?></div>
</div>

<div class="card">
    <i class="bi bi-clock card-icon"></i>
    <h3>Kendaraan Masih Parkir</h3>
    <div class="angka"><?= $parkir['parkir'] ?></div>
</div>

<div class="card">
    <i class="bi bi-archive card-icon"></i>
    <h3>Sisa Kapasitas</h3>
    <div class="angka"><?= $sisa_kapasitas ?></div>
</div>

</div>

<!-- TABLE -->
<div class="table-container">
<h3>Riwayat Transaksi Hari Ini</h3>

<table>
<tr>
    <th>No</th>
    <th>Plat Nomor</th>
    <th>Jenis</th>
    <th>Waktu</th>
    <th>Status</th>
    <th>Opsi</th>
</tr>

<?php 
$no=1;
while($row = mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['plat_nomor'] ?></td>
    <td><?= $row['nama_jenis'] ?></td>
    <td><?= $row['waktu_masuk'] ?></td>

    <td>
        <?php if($row['status']=='masuk'){ ?>
            <span class="status-masuk">Parkir</span>
        <?php } else { ?>
            <span class="status-keluar">Keluar</span>
        <?php } ?>
    </td>

   <tr>
    <td><?= $no++; ?></td>
    <td><?= $row['plat_nomor']; ?></td>
    <td><?= $row['nama_jenis']; ?></td>
    <td><?= $row['waktu_masuk']; ?></td>
    <td>
        <?php if($row['status'] == 'parkir'){ ?>
            <span class="badge bg-warning text-dark">Parkir</span>
        <?php } else { ?>
            <span class="badge bg-danger">Keluar</span>
        <?php } ?>
    </td>
    <td>
        <?php if($row['status'] == 'parkir'){ ?>
            <a href="edit_transaksi.php?id=<?= $row['id_parkir']; ?>" class="btn btn-sm btn-info">Edit</a>
            <a href="cetak_masuk.php?id=<?= $row['id_parkir']; ?>" target="_blank" class="btn btn-sm btn-success">Cetak</a>
        <?php } else { ?>
            <a href="cetak_struk_final.php?id=<?= $row['id_parkir']; ?>" target="_blank" class="btn btn-sm btn-secondary">Cetak Struk</a>
        <?php } ?>
    </td>
</tr>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>