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
    .main-content {
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

    /* CONTAINER & BUTTON */
    .container {
        padding: 0 30px;
    }

    .btn-tambah {
        display: inline-block;
        background: var(--active-yellow);
        color: black;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: 0.2s;
    }

    .btn-tambah:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    }

    /* TABLE STYLING (FIGMA STYLE) */
    .table-container {
        border-radius: 8px;
        overflow: hidden;
        /* Supaya sudut tabel melengkung */
    }

    .parking-table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    .parking-table th {
        background-color: var(--table-header);
        color: white;
        padding: 15px;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .parking-table td {
        padding: 12px;
        font-size: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Zebra Row Warna Hijau */
    .parking-table tr:nth-child(odd) td {
        background-color: var(--table-row-odd);
    }

    .parking-table tr:nth-child(even) td {
        background-color: var(--table-row-even);
    }

    /* Action Buttons (Edit & Hapus) */
    .btn-action {
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        font-size: 12px;
        margin: 0 2px;
    }

    .btn-info {
        background-color: #ffffff;
        color: #333;
    }

    /* Putih seperti di gambar figma */
    .btn-danger {
        background-color: #d63031;
    }
</style>

<head>
    <!-- TAMBAHAN ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<div class="sidebar">
    <h2>E-Parking<br>System</h2>
    <a href="index.php"><i class="bi bi-house-door"></i> Dashboard</a>
    <a href="data_user.php"><i class="bi bi-people"></i> Data User</a>
    <a href="jenis_kendaraan.php" class="active"><i class="bi bi-bicycle"></i> Jenis Kendaraan</a>
    <a href="pembayaran.php"><i class="bi bi-cash"></i> Pembayaran</a>
    <a href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:50px;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <div class="header-title">Data Jenis Kendaraan</div>
        <img src="../logo.png" class="header-logo">
    </div>

    <div class="container">
        <a href="jenis_kendaraan_tambah.php" class="btn-tambah">+ Tambah Jenis Kendaraan</a>

        <div class="table-container">
            <table class="parking-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Jenis</th>
                        <th>Tarif</th>
                        <th>Kapasitas</th>
                        <th width="20%">OPSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $data = mysqli_query($koneksi, "select * from t_jenis_kendaraan");
                    $no = 1;
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['nama_jenis']; ?></td>
                            <td>Rp <?php echo number_format($d['tarif'], 0, ',', '.'); ?></td>
                            <td><?php echo $d['kapasitas']; ?></td>
                            <td>
                                <a href="jenis_kendaraan_edit.php?id=<?php echo $d['id_jenis']; ?>" class="btn-action btn-info"><i class="bi bi-pencil-fill"></i></a>
                                <a href="jenis_kendaraan_hapus.php?id=<?php echo $d['id_jenis']; ?>" class="btn-action btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>