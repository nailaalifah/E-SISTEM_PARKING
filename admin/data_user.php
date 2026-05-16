<?php include '../koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Data User</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{font-family:'Inter';margin:0;padding:0;box-sizing:border-box;}
body{background:#ffffff;} /* REVISI: Mengubah background body menjadi putih polos */

:root{
--hijau1:#346739;        /* REVISI: Hijau tua sidebar utama */
--hijau2:#79AE6F;        /* REVISI: Hijau muda gradasi sidebar */
--kuning:#FFDE42;        /* REVISI: Kuning cerah active menu & button */
--table-header:#4D5D30;   /* REVISI: Hijau gelap header tabel */
--table-row-odd:#87A971;  /* REVISI: Hijau baris ganjil */
--table-row-even:#A2C18E; /* REVISI: Hijau baris genap */
}


/* SIDEBAR */
    .sidebar {
        width: 220px;
        height: 100vh;
        position: fixed;
        background: linear-gradient(to bottom, var(--hijau1), var(--hijau2));
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
        background: var(--kuning);
        color: black;
        border-radius: 25px 0 0 25px;
        margin-left: 10px;
        font-weight: bold;
    }

    .sidebar a i {
        margin-right: 10px;
    }

/* MAIN */
.main{margin-left:220px;}

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

/* BUTTON */
.btn-tambah{
background:var(--kuning);
padding:8px 15px;
border-radius:10px;
display:inline-block;
margin:15px;
text-decoration:none;
color:black;font-weight:bold;
}

/* TABLE */
.table{
margin:0 15px;
width:95%;
border-collapse:collapse;
text-align:center;
}

.table th{
background:var(--table-header); /* REVISI: Warna header tabel laporan */
color:white;padding:12px;
}

.table td{
padding:10px;
font-size: 14px;
}

/* REVISI: Mengubah warna baris tabel agar sama persis dengan halaman laporan/jenis kendaraan */
.table tr:nth-child(odd) td {background:var(--table-row-odd);}
.table tr:nth-child(even) td {background:var(--table-row-even);}

/* BADGE ROLE */
.badge{
background:#f4e7b6;
padding:5px 10px;
border-radius:10px;
font-weight: bold;
font-size: 12px;
}

/* ACTION */
.btn-icon{
padding:5px 8px;
margin:2px;
border-radius:5px;
text-decoration:none;
}

.edit{background:#ffffff;color:black;}
.hapus{background:#d63031;color:white;}
</style>

</head>
<body>

<div class="sidebar">
    <h2>E-Parking<br>System</h2>
    <a href="index.php"><i class="bi bi-house-door"></i> Dashboard</a>
    <a href="data_user.php" class="active"><i class="bi bi-people"></i> Data User</a>
    <a href="jenis_kendaraan.php"><i class="bi bi-bicycle"></i> Jenis Kendaraan</a>
    <a href="pembayaran.php"><i class="bi bi-cash"></i> Pembayaran</a>
    <a href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:50px;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">
<div class="header">
    <div class="header-title">Data User</div>
    <img src="../logo.png" class="header-logo">
</div>

<a href="tambah_user.php" class="btn-tambah">+ Tambah User</a>

<table class="table">
<thead>
<tr>
<th>Nama</th>
<th>Username</th>
<th>Password</th>
<th>Role</th>
<th>Opsi</th>
</tr>
</thead>
<tbody>

<?php
$data = mysqli_query($koneksi,"SELECT * FROM t_user");
while($d=mysqli_fetch_array($data)){
?>

<tr>
<td><?= $d['nama'] ?></td>
<td><?= $d['username'] ?></td>
<td><?= $d['password'] ?></td>
<td>
    <span class="badge"><?= $d['role'] == '1' ? 'Admin' : 'Petugas' ?></span>
</td>
<td>
<a href="edit_user.php?id=<?= $d['id_user'] ?>" class="btn-icon edit"><i class="bi bi-pencil"></i></a>
<a href="hapus_user.php?id=<?= $d['id_user'] ?>" class="btn-icon hapus"><i class="bi bi-trash"></i></a>
</td>
</tr>

<?php } ?>
</tbody>
</table>

</div>
</body>
</html>