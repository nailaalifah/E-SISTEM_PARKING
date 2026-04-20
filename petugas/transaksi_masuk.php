<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../koneksi.php';

// DATA JENIS
$jenis = mysqli_query($koneksi, "SELECT * FROM t_jenis_kendaraan");

// HITUNG PARKIR AKTIF
$q_parkir = mysqli_query($koneksi, "
    SELECT COUNT(*) as total 
    FROM t_parkir 
    WHERE status='masuk'
");
$data_parkir = mysqli_fetch_assoc($q_parkir);

// KAPASITAS
$q_kapasitas = mysqli_query($koneksi, "
    SELECT kapasitas FROM t_jenis_kendaraan WHERE id_jenis=1
");
$data_kapasitas = mysqli_fetch_assoc($q_kapasitas);

// SIMPAN
if(isset($_POST['ambil_tiket'])){

    if($data_parkir['total'] >= $data_kapasitas['kapasitas']){
        echo "<script>alert('Parkiran penuh!'); window.location='index.php';</script>";
        exit;
    }

    $plat_nomor = strtoupper($_POST['plat_nomor']);
    $id_jenis   = $_POST['id_jenis'];
    $id_user    = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 1;

    // INSERT DULU
    $query = "INSERT INTO t_parkir 
    (id_jenis, plat_nomor, waktu_masuk, status, sumber_input, id_user)
    VALUES 
    ('$id_jenis','$plat_nomor',NOW(),'masuk','petugas','$id_user')";

    if(mysqli_query($koneksi,$query)){

        $id_terakhir = mysqli_insert_id($koneksi);

        // BUAT KODE TIKET (ANTI DUPLICATE)
        $kode_tiket = "PK-" . $id_terakhir;

        mysqli_query($koneksi, "
            UPDATE t_parkir 
            SET kode_tiket='$kode_tiket', qr_code='$kode_tiket'
            WHERE id_parkir='$id_terakhir'
        ");

        header("Location: ambil_tiket.php?id=".$id_terakhir);
        exit;

    }else{
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Ambil Tiket Parkir</title>

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
}

input, select{
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
}
</style>
</head>

<body>

<div class="card">
<h3>Ambil Tiket Parkir</h3>

<img src="../logo.png" width="80">

<form method="POST">

<input type="text" name="plat_nomor" placeholder="Plat Nomor" required>

<select name="id_jenis" required>
<option value="">Pilih Jenis</option>
<?php while($j=mysqli_fetch_assoc($jenis)){ ?>
<option value="<?= $j['id_jenis'] ?>"><?= $j['nama_jenis'] ?></option>
<?php } ?>
</select>

<button type="submit" name="ambil_tiket">Ambil Tiket</button>

</form>
</div>

</body>
</html>