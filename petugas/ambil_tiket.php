<?php
include '../koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "
    SELECT p.*, j.nama_jenis 
    FROM t_parkir p
    JOIN t_jenis_kendaraan j ON p.id_jenis = j.id_jenis
    WHERE p.id_parkir='$id'
");

$d = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Struk Parkir</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#79AE6F;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.struk{
    background:#FFDE42;
    padding:25px;
    border-radius:20px;
    width:260px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.logo{
    width:60px;
    margin-bottom:10px;
}

.qr{
    margin:15px 0;
}

.data{
    text-align:left;
    font-size:13px;
    margin-top:10px;
}

.data p{
    margin:5px 0;
}

.line{
    border-top:1px dashed black;
    margin:10px 0;
}

button{
    margin-top:10px;
    width:100%;
    padding:10px;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

.print{
    background:#1B0C0C;
    color:white;
}

.back{
    background:#ccc;
}
</style>
</head>

<body>

<div class="struk">

<img src="../logo.png" class="logo">

<h3>E-Parking</h3>

<div class="qr">
<img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?= $d['qr_code'] ?>">
</div>

<div class="line"></div>

<div class="data">
<p><b>Kode :</b> <?= $d['kode_tiket'] ?></p>
<p><b>Plat :</b> <?= $d['plat_nomor'] ?></p>
<p><b>Jenis :</b> <?= $d['nama_jenis'] ?></p>
<p><b>Masuk :</b> <?= $d['waktu_masuk'] ?></p>
</div>

<div class="line"></div>

<p style="font-size:12px;">Simpan tiket ini ya!</p>

<button onclick="window.print()" class="print">Cetak</button>
<button onclick="window.location.href='index.php'" class="back">Kembali</button>

</div>

</body>
</html>