<style>
    :root {
        --sidebar-green: #346739;
        --sidebar-light: #79AE6F;
        --active-yellow: #FFDE42;
        --bg-light: #F2EDC2;
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
        font-weight: bold;
    }

    /* TAMBAHAN ICON MENU */
    .sidebar a i {
        margin-right: 10px;
    }

    /* MAIN */
    .main-content {
        margin-left: 220px;
    }

    /* HEADER */
    .header {
        background: linear-gradient(to right, #FFDE42, #ffffff);
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .header-title {
        font-size: 26px;
        font-weight: bold;
    }

    .header-logo {
        width: 50px;
    }
</style>

<div class="sidebar">
    <h2>E-Parking<br>System</h2>

    <!-- MENU (SUDAH ADA ICON + LINK) -->
    <a href="index.php" class="active"><i class="bi bi-house-door"></i> Dashboard</a>
    <a href="data_user.php"><i class="bi bi-people"></i> Data User</a>
    <a href="jenis_kendaraan.php"><i class="bi bi-bicycle"></i> Jenis Kendaraan</a>
    <a href="pembayaran.php"><i class="bi bi-cash"></i> Pembayaran</a>
    <a href="laporan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:50px;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <div class="header-title">Dashboard Admin</div>
        <img src="../logo.png" class="header-logo">
    </div>