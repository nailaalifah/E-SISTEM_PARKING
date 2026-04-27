<?php include '../koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Data User</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{font-family:'Inter';margin:0;padding:0;box-sizing:border-box;}
body{background:#e5e5e5;}

:root{
--hijau1:#2f4f1e;
--hijau2:#6c8c4c;
--kuning:#f7d63b;
}

/* SIDEBAR */
.sidebar{
width:220px;height:100vh;position:fixed;
background:linear-gradient(var(--hijau1),var(--hijau2));
color:white;padding-top:20px;
}
.sidebar h2{text-align:center;margin-bottom:30px;}
.sidebar a{display:block;padding:15px;color:white;text-decoration:none;}
.sidebar a.active{background:var(--kuning);color:black;border-radius:20px 0 0 20px;}

/* MAIN */
.main{margin-left:220px;}
.header{
background:#e8d98b;
padding:15px 25px;
display:flex;justify-content:space-between;
align-items:center;
font-size:24px;font-weight:bold;
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
background:#4a5d2c;
color:white;padding:12px;
}

.table td{
padding:10px;
}

.table tr:nth-child(odd){background:#8fab75;}
.table tr:nth-child(even){background:#a8c294;}

/* BADGE ROLE */
.badge{
background:#f4e7b6;
padding:5px 10px;
border-radius:10px;
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
<div class="header">Data User</div>

<a href="tambah_user.php" class="btn-tambah">+ Tambah User</a>

<table class="table">
<tr>
<th>Nama</th>
<th>Username</th>
<th>Password</th>
<th>Role</th>
<th>Opsi</th>
</tr>

<?php
$data = mysqli_query($koneksi,"SELECT * FROM t_user");
while($d=mysqli_fetch_array($data)){
?>

<tr>
<td><?= $d['nama'] ?></td>
<td><?= $d['username'] ?></td>
<td><?= $d['password'] ?></td>
<td><span class="badge"><?= $d['role'] ?></span></td>
<td>
<a href="edit_user.php?id=<?= $d['id_user'] ?>" class="btn-icon edit"><i class="bi bi-pencil"></i></a>
<a href="hapus_user.php?id=<?= $d['id_user'] ?>" class="btn-icon hapus"><i class="bi bi-trash"></i></a>
</td>
</tr>

<?php } ?>
</table>

</div>
</body>
</html>