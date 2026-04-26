<!DOCTYPE html>
<html>
<head>
    <title>Ambil Tiket Parkir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(180deg, #FFDE42 0%, #79AE6F 100%); height: 100vh; overflow: hidden; }
        
        /* Animasi Splash Logo */
        .splash-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #FFDE42; display: flex; align-items: center; justify-content: center; z-index: 999; animation: fadeOut 1s forwards 2s; }
        .logo-splash { width: 150px; animation: shrink 1s forwards 2s; }

        @keyframes fadeOut { to { opacity: 0; visibility: hidden; } }
        @keyframes shrink { to { transform: scale(0.5); } }

        /* Form Layout */
        .form-card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-width: 500px; width: 90%; }
        .btn-ambil { background: #3E4E35; color: white; border-radius: 10px; padding: 10px 30px; border: none; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="splash-container">
        <img src="../logo.png" class="logo-splash" alt="Logo">
    </div>

    <div class="form-card text-center">
        <img src="../logo.png" width="80" class="mb-3">
        <h3 class="fw-bold mb-4">Ambil Tiket Parkir</h3>
        <form action="proses_tiket.php" method="POST">
            <div class="mb-3 text-start">
                <label class="fw-bold">Plat Nomor</label>
                <input type="text" name="plat_nomor" class="form-control bg-light border-0" placeholder="Contoh: H 1234 AB" required>
            </div>
            <div class="mb-4 text-start">
                <label class="fw-bold">Jenis Kendaraan</label>
                <select name="id_jenis" class="form-select bg-light border-0" required>
                    <option value="">Pilih...</option>
                    <?php 
                    include '../koneksi.php';
                    $jenis = mysqli_query($koneksi, "SELECT * FROM t_jenis_kendaraan");
                    while($j = mysqli_fetch_array($jenis)){
                        echo "<option value='".$j['id_jenis']."'>".$j['nama_jenis']."</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn-ambil fw-bold">Ambil Tiket</button>
        </form>
    </div>

</body>
</html>