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
    border-radius: 20px;
    margin: 5px;
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
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
    <a href="index.php" class="active">Dashboard</a>
    <a href="#">Data User</a>
    <a href="#">Jenis Kendaraan</a>
    <a href="#">Pembayaran</a>
    <a href="#">Laporan</a>
    <a href="../logout.php" style="margin-top:50px;">Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <div class="header-title">Dashboard Admin</div>
        <img src="../logo.png" class="header-logo">
    </div>