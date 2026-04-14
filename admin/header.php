<style>
    :root {
        /* Gradasi Hijau untuk Sidebar (dari hijau agak terang ke hijau tua) */
        --sidebar-gradient: linear-gradient(180deg, #748E3D 0%, #4C5C2D 100%);
        --active-yellow: #FFDE42; 
        --text-active: #1B0C0C;
    }

    body { margin: 0; font-family: 'Segoe UI', sans-serif; display: flex; }

    /* --- SIDEBAR UTAMA --- */
    .sidebar {
        width: 240px;
        /* Ini yang membuat seluruh area menu menjadi gradasi hijau */
        background: var(--sidebar-gradient); 
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        color: white;
        box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
    }

    .sidebar h2 {
        padding: 30px 20px;
        text-align: center;
        font-size: 1.2rem;
        margin: 0;
    }

    /* --- MENU DASHBOARD, USER, DLL --- */
    .sidebar a {
        display: flex;
        align-items: center;
        padding: 15px 25px;
        color: white;
        text-decoration: none;
        font-size: 0.95rem;
        transition: 0.3s;
        margin: 5px 0;
        gap: 15px;
    }

    /* --- KOTAK KUNING MENU AKTIF --- */
    .sidebar a.active {
        background-color: var(--active-yellow); /* Kuning solid di atas gradasi hijau */
        color: var(--text-active) !important;   /* Teks jadi hitam */
        font-weight: bold;
        /* Membuat kotak memanjang penuh sesuai area menu */
        width: 100%;
        box-sizing: border-box;
    }

    /* Area Logout di bawah */
    .logout-section {
        margin-top: auto;
        border-top: 1px solid rgba(255,255,255,0.2);
        padding-bottom: 20px;
    }

    /* --- KONTEN UTAMA (Kanan) --- */
    .main-content {
        margin-left: 240px;
        flex: 1;
        min-height: 100vh;
        background-color: #f4f4f4; /* Area dashboard yang putih/abu terang */
    }
</style>

<div class="sidebar">
    <h2>E - Parking<br>System</h2>
    
    <div class="menu-list">
        <a href="index.php" id="menu-dash">🏠 Dashboard</a>
        <a href="data_user.php" id="menu-user">👥 Data User</a>
        <a href="jenis_kendaraan.php">🏍️ Jenis Kendaraan</a>
        <a href="pembayaran.php">💰 Pembayaran</a>
        <a href="laporan.php">📄 Laporan</a>
    </div>

    <div class="logout-section">
        <a href="../logout.php">🚪 Logout</a>
    </div>
</div>