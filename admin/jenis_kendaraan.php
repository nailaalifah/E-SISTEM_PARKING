<?php 
include 'config.php';
// Ambil data dari database
$query = mysqli_query($conn, "SELECT * FROM jenis_kendaraan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>E-Parking System</title>
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <h2 class="logo">E - Parking System</h2>
            <nav>
                <a href="#">Dashboard</a>
                <a href="#">Data User</a>
                <a href="#" class="active">Jenis Kendaraan</a>
                <a href="#">Pembayaran</a>
            </nav>
        </aside>

        <main class="main-content">
            <header>
                <h1>Data Jenis Kendaraan</h1>
            </header>

            <a href="tambah.php" class="btn-tambah">+ Tambah Jenis Kendaraan</a>

            <table class="parking-table">
                <thead>
                    <tr>
                        <th>Nama Jenis</th>
                        <th>Tarif</th>
                        <th>Kapasitas</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $row['nama_jenis']; ?></td>
                        <td><?= $row['tarif']; ?></td>
                        <td><?= $row['kapasitas']; ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">✎</a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-delete">🗑</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
<style>
    /* Layout Dasar */
.app-container { display: flex; min-height: 100vh; font-family: sans-serif; }

/* Sidebar Gradasi (Sangat Mirip Gambar) */
.sidebar {
    width: 250px;
    background: linear-gradient(180deg, #74913d 0%, #2b4012 100%);
    color: white;
    padding: 20px;
}

.sidebar .active {
    background-color: #f1c40f; /* Kuning di Figma */
    color: black;
    display: block;
    padding: 10px;
    border-radius: 8px 0 0 8px;
    margin-right: -20px;
    text-decoration: none;
}

/* Tabel Style */
.parking-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.parking-table thead {
    background-color: #4d5d30; /* Hijau Tua */
    color: white;
}

/* Baris Selang-Seling (Zebra) */
.parking-table tr:nth-child(odd) { background-color: #87a971; }
.parking-table tr:nth-child(even) { background-color: #a2c18e; }

.parking-table td, .parking-table th {
    padding: 12px;
    text-align: center;
    border: 1px solid rgba(0,0,0,0.1);
}
</style>