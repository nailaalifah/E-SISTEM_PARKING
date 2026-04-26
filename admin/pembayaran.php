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

    /* CSS KHUSUS HALAMAN PEMBAYARAN */
    .filter-section {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        padding: 0 30px;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-weight: bold;
        font-size: 14px;
    }

    .filter-input {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #F2EDC2;
        font-size: 13px;
        outline: none;
    }

    .summary-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        padding: 0 30px;
        margin-bottom: 30px;
    }

    .summary-card {
        background-color: #F2EDC2;
        border: 2px solid var(--sidebar-green);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .summary-icon {
        font-size: 30px;
        background: var(--sidebar-green);
        color: white;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .summary-info p {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .summary-info h3 {
        font-size: 24px;
        color: #E67E22;
        margin-top: 5px;
    }

    .parking-table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
        border-radius: 10px;
        overflow: hidden;
    }

    .parking-table th {
        background-color: var(--table-header);
        color: white;
        padding: 15px;
        font-size: 14px;
    }

    .parking-table tr:nth-child(odd) td {
        background-color: var(--table-row-odd);
    }

    .parking-table tr:nth-child(even) td {
        background-color: var(--table-row-even);
    }

    .parking-table td {
        padding: 12px;
        border: 0.5px solid rgba(0, 0, 0, 0.05);
    }

    .badge {
        padding: 5px 15px;
        border-radius: 15px;
        font-weight: bold;
        border: 1px solid #333;
    }

    .qris {
        background-color: #79AE6F;
    }

    .tunai {
        background-color: #95a5a6;
        color: white;
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        padding: 20px 30px;
        align-items: center;
    }

    .btn-action {
        background-color: #F2EDC2;
        border: 1px solid #333;
        padding: 8px 15px;
        border-radius: 8px;
        text-decoration: none;
        color: black;
        font-weight: bold;
        font-size: 13px;
        cursor: pointer;
    }
</style>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<div class="sidebar">
    <h2>E-Parking<br>System</h2>
    <a href="index.php"><i class="bi bi-house-door"></i> Dashboard</a>
    <a href="data_user.php"><i class="bi bi-people"></i> Data User</a>
    <a href="jenis_kendaraan.php"><i class="bi bi-bicycle"></i> Jenis Kendaraan</a>
    <a href="pembayaran.php" class="active"><i class="bi bi-cash"></i> Pembayaran</a>
    <a href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:50px;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <div class="header-title">Data Pembayaran</div>
        <img src="../logo.png" class="header-logo">
    </div>

    <?php
    include '../koneksi.php';

    $tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-d');
    $tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : date('Y-m-d');
    $metode = isset($_GET['metode']) ? $_GET['metode'] : 'Semua';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $where_clause = "WHERE DATE(p.waktu_bayar) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    if ($metode != 'Semua') {
        $where_clause .= " AND p.metode_pembayaran = '$metode'";
    }
    if ($search != '') {
        $where_clause .= " AND (pk.plat_nomor LIKE '%$search%' OR p.id_parkir LIKE '%$search%')";
    }

    // Query untuk 4 Kotak Ringkasan (Menghitung Pendapatan Bersih: bayar - kembalian)
    $sql_ringkasan = "SELECT 
        SUM(p.jumlah_bayar - p.kembalian) as total_masuk,
        COUNT(*) as jml_transaksi,
        SUM(CASE WHEN p.metode_pembayaran = 'QRIS' THEN (p.jumlah_bayar - p.kembalian) ELSE 0 END) as total_qris,
        SUM(CASE WHEN p.metode_pembayaran = 'Tunai' THEN (p.jumlah_bayar - p.kembalian) ELSE 0 END) as total_tunai
        FROM t_pembayaran p
        LEFT JOIN t_parkir pk ON p.id_parkir = pk.id_parkir 
        $where_clause";

    $q_ringkasan = mysqli_query($koneksi, $sql_ringkasan);
    $res = mysqli_fetch_assoc($q_ringkasan);

    // Query untuk Tabel (JOIN ke t_parkir dan t_jenis_kendaraan)
    $sql_tabel = "SELECT p.*, pk.plat_nomor, j.nama_jenis 
                  FROM t_pembayaran p 
                  LEFT JOIN t_parkir pk ON p.id_parkir = pk.id_parkir 
                  LEFT JOIN t_jenis_kendaraan j ON pk.id_jenis = j.id_jenis
                  $where_clause ORDER BY p.id_pembayaran DESC";
    $data_pembayaran = mysqli_query($koneksi, $sql_tabel);
    ?>

    <form method="GET" action="" class="filter-section">
        <div class="filter-group">
            <label><i class="bi bi-calendar3"></i> Tanggal</label>
            <div style="display: flex; gap: 5px; align-items: center;">
                <input type="date" name="tgl_mulai" class="filter-input" value="<?= $tgl_mulai ?>">
                <span>-</span>
                <input type="date" name="tgl_selesai" class="filter-input" value="<?= $tgl_selesai ?>">
            </div>
        </div>
        <div class="filter-group">
            <label><i class="bi bi-credit-card"></i> Metode Pembayaran</label>
            <select name="metode" class="filter-input">
                <option value="Semua" <?= $metode == 'Semua' ? 'selected' : '' ?>>Semua</option>
                <option value="Tunai" <?= $metode == 'Tunai' ? 'selected' : '' ?>>Tunai</option>
                <option value="QRIS" <?= $metode == 'QRIS' ? 'selected' : '' ?>>QRIS</option>
            </select>
        </div>
        <div class="filter-group" style="flex-grow: 1;">
            <label><i class="bi bi-search"></i> Search</label>
            <div style="display:flex; gap:5px;">
                <input type="text" name="search" class="filter-input" placeholder="Cari Kode tiket/plat nomor" value="<?= $search ?>" style="width: 100%;">
                <button type="submit" class="btn-action" style="background-color: var(--active-yellow);">Cari</button>
            </div>
        </div>
    </form>

    <div class="summary-container">
        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="summary-info">
                <p>Total Pemasukan</p>
                <h3>Rp <?= number_format($res['total_masuk'] ?? 0, 0, ',', '.') ?></h3>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-qr-code-scan"></i></div>
            <div class="summary-info">
                <p>Total QRIS</p>
                <h3>Rp <?= number_format($res['total_qris'] ?? 0, 0, ',', '.') ?></h3>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-file-earmark-text"></i></div>
            <div class="summary-info">
                <p>Jumlah Transaksi</p>
                <h3><?= $res['jml_transaksi'] ?? 0 ?> Transaksi</h3>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-wallet2"></i></div>
            <div class="summary-info">
                <p>Total Tunai</p>
                <h3>Rp <?= number_format($res['total_tunai'] ?? 0, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="parking-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>kode tiket</th>
                    <th>plat nomor</th>
                    <th>jenis</th>
                    <th>Metode</th>
                    <th>bayar</th>
                    <th>Kembalian</th>
                    <th>Waktu Bayar</th>
                    <th>Petugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data_pembayaran && mysqli_num_rows($data_pembayaran) > 0) {
                    while ($row = mysqli_fetch_assoc($data_pembayaran)): ?>
                        <tr>
                            <td><?= $row['id_pembayaran'] ?></td>
                            <td><?= $row['id_parkir'] ?></td>
                            <td><?= $row['plat_nomor'] ?></td>
                            <td><?= $row['nama_jenis'] ?></td>
                            <td>
                                <span class="badge <?= strtolower($row['metode_pembayaran']) ?>">
                                    <?= $row['metode_pembayaran'] ?>
                                </span>
                            </td>
                            <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($row['kembalian'], 0, ',', '.') ?></td>
                            <td><?= date('H.i', strtotime($row['waktu_bayar'])) ?></td>
                            <td>Admin</td>
                            <td><a href="detail.php?id=<?= $row['id_pembayaran'] ?>" class="btn-action">Detail</a></td>
                        </tr>
                    <?php endwhile;
                } else { ?>
                    <tr>
                        <td colspan="10" style="padding:20px;">Data tidak ditemukan</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="table-footer">
            <div style="display:flex; gap:10px;">
                <a href="export_pdf.php?tgl_mulai=<?= $tgl_mulai ?>&tgl_selesai=<?= $tgl_selesai ?>&metode=<?= $metode ?>" class="btn-action">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
                <button onclick="window.print()" class="btn-action">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>