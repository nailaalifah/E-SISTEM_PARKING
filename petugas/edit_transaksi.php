<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../koneksi.php';

// ambil id
$id = $_GET['id'];

// ambil data lama
$data = mysqli_query($koneksi, "
    SELECT * FROM t_parkir WHERE id_parkir='$id'
");
$d = mysqli_fetch_assoc($data);

// proses update
if(isset($_POST['update'])){
    $plat_nomor = strtoupper($_POST['plat_nomor']);

    mysqli_query($koneksi, "
        UPDATE t_parkir 
        SET plat_nomor='$plat_nomor'
        WHERE id_parkir='$id'
    ");

    echo "<script>alert('Data berhasil diupdate'); window.location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Transaksi</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#FFDE42,#79AE6F);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    background:white;
    padding:30px;
    border-radius:15px;
    width:320px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:none;
    border-radius:10px;
    background:#eee;
}

button{
    background:#346739;
    color:white;
    padding:12px;
    border:none;
    border-radius:10px;
    width:100%;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#2a5a2f;
}

.back{
    display:inline-block;
    margin-bottom:10px;
    text-decoration:none;
    color:#333;
}
</style>
</head>

<body>

<div class="card">

    <a href="index.php" class="back">← Kembali</a>

    <h3>Edit Plat Nomor</h3>

    <img src="../logo.png" width="80">

    <form method="POST">

        <input 
            type="text" 
            name="plat_nomor" 
            value="<?= $d['plat_nomor'] ?>" 
            required
        >

        <button type="submit" name="update">
            Simpan Perubahan
        </button>

    </form>
</div>

</body>
</html>