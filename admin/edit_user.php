<?php
include '../koneksi.php';
$id=$_GET['id'];
$data=mysqli_query($koneksi,"SELECT * FROM users WHERE id_user='$id'");
$d=mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{background:#ddd;font-family:Inter;}
.container{
width:60%;margin:50px auto;
background:#f7d63b;padding:30px;
border-radius:10px;
}
input,select{width:100%;padding:10px;margin:10px 0;}
button{background:#2f4f1e;color:white;padding:10px;}
</style>
</head>

<body>

<div class="container">
<h2>Edit User</h2>

<form method="POST">
Nama<input type="text" name="nama" value="<?= $d['nama'] ?>">
Username<input type="text" name="username" value="<?= $d['username'] ?>">
Password<input type="text" name="password" value="<?= $d['password'] ?>">

<select name="role">
<option <?= $d['role']=='Petugas'?'selected':'' ?>>Petugas</option>
<option <?= $d['role']=='Admin'?'selected':'' ?>>Admin</option>
</select>

<button name="update">Simpan</button>
</form>
</div>

<?php
if(isset($_POST['update'])){
mysqli_query($koneksi,"UPDATE users SET 
nama='$_POST[nama]',
username='$_POST[username]',
password='$_POST[password]',
role='$_POST[role]'
WHERE id_user='$id'");
header("location:data_user.php");
}
?>