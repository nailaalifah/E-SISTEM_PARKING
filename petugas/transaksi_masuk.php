<?php
session_start();
include '../koneksi.php';

// PROSES SIMPAN DATA
if (isset($_POST['ambil_tiket'])) {
    $plat_nomor = strtoupper($_POST['plat_nomor']);
    $id_jenis   = $_POST['id_jenis'];
    $waktu_masuk = date('Y-m-d H:i:s');
    
    // Pastikan session id_user ada, jika tidak ada set default atau arahkan ke login
    $id_user    = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 1; 

    $kode_tiket = "PK-" . date('ymdHis');
    $qr_code    = $kode_tiket; 

    $query = "INSERT INTO t_parkir (kode_tiket, qr_code, id_jenis, plat_nomor, waktu_masuk, sumber_input, id_user) 
              VALUES ('$kode_tiket', '$qr_code', '$id_jenis', '$plat_nomor', '$waktu_masuk', 'Petugas', '$id_user')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Tiket Berhasil Dicetak!'); window.location='index.php';</script>";
    }
}

// AMBIL DATA JENIS KENDARAAN (Pastikan nama kolom sesuai foto database kamu)
$jenis_query = mysqli_query($koneksi, "SELECT * FROM t_jenis_kendaraan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ambil Tiket Parkir</title>
    <style>
        :root {
            --hijau-tua: #346739;
            --hijau-muda: #79AE6F;
            --kuning: #FFDE42;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, var(--kuning) 30%, var(--hijau-muda) 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .back-arrow {
            position: absolute;
            top: 30px;
            left: 30px;
            text-decoration: none;
            color: #1b0c0c;
            font-size: 30px;
            font-weight: bold;
        }

        .card {
            background: #fff;
            width: 500px; /* Diperlebar sedikit agar tidak sesak */
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h1 {
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .logo-parking {
            width: 100px;
            margin-bottom: 30px;
        }

        .form-container {
            width: 100%;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 25px; /* Jarak antar input */
        }

        .form-group label {
            width: 150px; /* Lebar label tetap agar rapi ke bawah */
            text-align: left;
            font-weight: bold;
            font-size: 16px;
        }

        .form-group input, .form-group select {
            flex: 1;
            padding: 12px 15px;
            border: none;
            background: #f0f0f0;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
        }

        .btn-ambil {
            background: var(--hijau-tua);
            color: white;
            border: none;
            padding: 15px 60px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .btn-ambil:hover {
            background: #264d2b;
            transform: scale(1.02);
        }
    </style>
</head>
<body>

    <a href="index.php" class="back-arrow">←</a>

    <div class="card">
        <h1>Ambil Tiket Parkir</h1>
        
        <div style="margin-bottom: 20px;">
             <img src="../logo.png" class="logo-parking" alt="E-Parking Logo" onerror="this.src='https://via.placeholder.com/100?text=Logo'">
        </div>

        <form action="" method="POST" class="form-container">
            <div class="form-group">
                <label>Plat Nomor</label>
                <input type="text" name="plat_nomor" placeholder="Masukkan Plat..." required>
            </div>

            <div class="form-group">
                <label>Jenis Kendaraan</label>
                <select name="id_jenis" required>
                    <option value="">-- Pilih --</option>
                    <?php 
                    if($jenis_query) {
                        while($row = mysqli_fetch_assoc($jenis_query)) { 
                            // Gunakan nama kolom yang sesuai dengan foto database (case sensitive)
                            echo "<option value='".$row['id_jenis']."'>".$row['nama_jenis']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="ambil_tiket" class="btn-ambil">Ambil Tiket</button>
        </form>
    </div>

</body>
</html>