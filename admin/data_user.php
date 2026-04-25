<?php
include '../koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- FONT -->
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
}

/* WARNA */
:root {
    --sidebar-green: #346739;
    --sidebar-light: #79AE6F;
    --active-yellow: #FFDE42;
    --table-header: #4D5D30;
    --table-row-even: #A2C18E;
    --table-row-odd: #87A971;
}

/* SIDEBAR */
.sidebar {
    width: 220px;
    height: 100vh;
    position: fixed;
    background: linear-gradient(to bottom, var(--sidebar-green), var(--sidebar-light));
    color: white;
    padding-top: 20px;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    padding: 15px 20px;
    color: white;
    text-decoration: none;
}

.sidebar a.active {
    background: var(--active-yellow);
    color: black;
    border-radius: 25px 0 0 25px;
    margin-left: 10px;
}

/* MAIN */
.main {
    margin-left: 220px;
}

/* HEADER */
.header {
    background: linear-gradient(to right, #FFDE42, #ffffff);
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
}

.container {
    padding: 20px 30px;
}

/* BUTTON */
.btn-tambah {
    background: var(--active-yellow);
    padding: 10px 15px;
    text-decoration: none;
    color: black;
    border-radius: 8px;
    display: inline-block;
    margin-bottom: 15px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}

th {
    background: var(--table-header);
    color: white;
    padding: 12px;
}

td {
    padding: 10px;
}

tr:nth-child(odd) {
    background: var(--table-row-odd);
}

tr:nth-child(even) {
    background: var(--table-row-even);
}

/* BUTTON AKSI */
.btn {
    padding: 5px 10px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
}

.edit {
    background: #ffffff;
    color: black;
}

.hapus {
    background: red;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>E-Parking</h2>
    <a href="index.php"><i class="bi bi-house"></i> Dashboard</a>
    <a href="data_user.php" class="active"><i class="bi bi-people"></i> Data User</a>
    <a href="jenis_kendaraan.php"><i class="bi bi-bicycle"></i> Kendaraan</a>
    <a href="pembayaran.php"><i class="bi bi-cash"></i> Pembayaran</a>
    <a href="laporan.php"><i class="bi bi-file-text"></i> Laporan</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="header">
    <h2>Data User</h2>
</div>

<div class="container">

<a href="tambah_user.php" class="btn-tambah">+ Tambah User</a>

<table>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Username</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM users");

while($d = mysqli_fetch_array($data)){
?>

<tr>
<td><?php echo $no++; ?></td>
<td><?php echo $d['nama']; ?></td>
<td><?php echo $d['username']; ?></td>
<td><?php echo $d['role']; ?></td>
<td>
    <a href="edit_user.php?id=<?php echo $d['id_user']; ?>" class="btn edit">Edit</a>
    <a href="hapus_user.php?id=<?php echo $d['id_user']; ?>" class="btn hapus">Hapus</a>
</td>
</tr>

<?php } ?>

</table>

</div>
</div>

</body>
</html>