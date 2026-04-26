<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: #f9f9f9;
        min-height: 100vh;
        width: 100%;
        /* Pastikan body ambil 100% lebar */
    }

    /* HEADER */
    .header-wrapper {
        display: flex;
        align-items: center;
        background: linear-gradient(to right, #FFDE42, #ffffff);
        padding: 10px 20px;
        margin-bottom: 40px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .btn-back {
        text-decoration: none;
        color: black;
        font-size: 20px;
        margin-right: 15px;
    }

    .header-title {
        font-size: 28px;
        font-weight: 800;
    }

    /* CARD KUNING */
    .card-yellow {
        background-color: #FFDE42;
        max-width: 700px;
        margin: 0 auto;
        padding: 50px 80px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    /* FORM LAYOUT */
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }

    .form-group label {
        flex: 0 0 150px;
        /* Lebar tetap untuk label agar input sejajar */
        font-weight: 700;
        font-size: 18px;
    }

    .form-control {
        flex: 1;
        background-color: #f1f1f1;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 16px;
        color: #666;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        /* Efek kedalaman */
        outline: none;
    }

    .form-control::placeholder {
        color: #bbb;
    }

    /* TOMBOL SIMPAN */
    .footer-form {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .btn-simpan {
        background-color: #2D3E1A;
        /* Hijau tua sesuai gambar */
        color: white;
        border: none;
        padding: 12px 60px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-simpan:hover {
        background-color: #1e2b12;
        transform: scale(1.05);
    }
</style>

<div class="header-wrapper">
    <a href="jenis_kendaraan.php" class="btn-back"><i class="bi bi-arrow-return-left"></i></a>
    <div class="header-title">Tambah Jenis Kendaraan</div>
</div>

<div class="card-yellow">
    <form method="POST" action="jenis_kendaraan_aksi.php">
        <div class="form-group">
            <label>Nama Jenis</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama jenis">
        </div>

        <div class="form-group">
            <label>Tarif</label>
            <input type="number" name="tarif" class="form-control" placeholder="Masukkan tarif">
        </div>

        <div class="form-group">
            <label>Kapasitas</label>
            <input type="text" name="kapasitas" class="form-control" placeholder="Masukan kapasitas">
        </div>

        <div class="footer-form">
            <button type="submit" class="btn-simpan">Simpan</button>
        </div>
    </form>
</div>