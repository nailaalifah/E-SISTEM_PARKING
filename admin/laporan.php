<?php
include '../koneksi.php';

// FILTER
$jenis   = isset($_GET['jenis']) ? $_GET['jenis'] : 'harian';
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
$bulan   = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun   = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// QUERY
if($jenis == 'harian'){
    $q = mysqli_query($koneksi,"
        SELECT p.*, u.nama 
        FROM t_parkir p
        JOIN t_user u ON p.id_user = u.id_user
        WHERE DATE(p.waktu_masuk) = '$tanggal'
        ORDER BY p.waktu_masuk DESC
    ");
}else{
    $q = mysqli_query($koneksi,"
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
while($d = mysqli_fetch_assoc($q)){
    $data[] = $d;
    $total_pendapatan += (int)$d['total_bayar'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Laporan</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}
body{background:#efefef;}

:root{
--hijau1:#2f4f1e;
--hijau2:#6c8c4c;
--kuning:#f7d63b;
--card1:#7ea567;
--card2:#3d6b3a;
--header:#e8d98b;
}

/* SIDEBAR */
.sidebar{
width:220px;height:100vh;position:fixed;
background:linear-gradient(var(--hijau1),var(--hijau2));
color:white;padding-top:20px;
}
.sidebar h2{text-align:center;margin-bottom:30px;}
.sidebar a{display:block;padding:15px;color:white;text-decoration:none;}
.sidebar a.active{
background:var(--kuning);color:black;
border-radius:20px 0 0 20px;margin-left:10px;
}

/* MAIN */
.main{margin-left:220px;}
.header{
background:var(--header);
padding:15px 25px;
display:flex;justify-content:space-between;
align-items:center;font-size:24px;font-weight:bold;
}

/* FILTER */
.filter{
background:#fff3a0;
margin:20px;
padding:15px;
border-radius:10px;
display:flex;
align-items:center;
gap:10px;
flex-wrap:wrap;
}
.filter select,.filter input{
padding:8px;border-radius:5px;border:none;
}
.btn{
background:#2f4f1e;color:white;
padding:8px 12px;border:none;border-radius:5px;
cursor:pointer;
}
.btn-print{
background:#ddd;color:black;
}

/* CARD */
.cards{margin:20px;}
.card{
display:inline-block;
width:220px;
padding:15px;
border-radius:10px;
color:white;
margin-right:10px;
}
.card1{background:var(--card1);}
.card2{background:var(--card2);}
.card h3{font-size:14px;margin-bottom:5px;}
.card h2{font-size:22px;}

/* TABLE */
.table-box{
background:#fff3a0;
margin:20px;
padding:15px;
border-radius:10px;
}
table{
width:100%;
border-collapse:collapse;
text-align:center;
}
th{
background:#4a5d2c;
color:white;
padding:12px;
}
td{padding:10px;}
tr:nth-child(odd){background:#8fab75;}
tr:nth-child(even){background:#a8c294;}

/* STATUS */
.status{
padding:5px 10px;
border-radius:10px;
font-size:12px;
color:white;
}
.keluar{background:#e74c3c;}
.masuk{background:#2ecc71;}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>E-Parking<br>System</h2>
    <a href="index.php"><i class="bi bi-house-door"></i> Dashboard</a>
    <a href="data_user.php"><i class="bi bi-people"></i> Data User</a>
    <a href="jenis_kendaraan.php"><i class="bi bi-bicycle"></i> Jenis Kendaraan</a>
    <a href="pembayaran.php"><i class="bi bi-cash"></i> Pembayaran</a>
    <a href="laporan.php" class="active"><i class="bi bi-file-earmark-text"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:50px;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>


<!-- MAIN -->
<div class="main">

<div class="header">
Data Laporan
<img src="../logo.png" width="40">
</div>

<!-- FILTER -->
<form class="filter" method="GET">
Jenis:
<select name="jenis" onchange="this.form.submit()">
<option value="harian" <?= $jenis=='harian'?'selected':'' ?>>Harian</option>
<option value="bulanan" <?= $jenis=='bulanan'?'selected':'' ?>>Bulanan</option>
</select>

<?php if($jenis=='harian'){ ?>
Tanggal:
<input type="date" name="tanggal" value="<?= $tanggal ?>">
<?php }else{ ?>
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

<!-- CARD -->
<div class="cards">
<div class="card card1">
<h3>Total Kendaraan</h3>
<h2><?= $total_kendaraan ?></h2>
</div>

<div class="card card2">
<h3>Total Pendapatan</h3>
<h2>Rp <?= number_format($total_pendapatan,0,',','.') ?></h2>
</div>
</div>

<!-- TABEL -->
<div class="table-box">
<h3>Data Parkir</h3>

<table>
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

<?php foreach($data as $d){ ?>
<tr>
<td><?= $d['kode_tiket'] ?></td>
<td><?= $d['plat_nomor'] ?></td>
<td><?= $d['id_jenis'] ?></td>
<td><?= $d['waktu_masuk'] ?></td>
<td><?= $d['waktu_keluar'] ?></td>
<td><?= $d['nama'] ?></td>
<td>Rp <?= number_format($d['total_bayar'],0,',','.') ?></td>
<td>
<?php if($d['waktu_keluar']){ ?>
<span class="status keluar">Keluar</span>
<?php }else{ ?>
<span class="status masuk">Masuk</span>
<?php } ?>
</td>
</tr>
<?php } ?>

</table>
</div>

</div>
</body>
</html>