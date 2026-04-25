<?php include '../koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah User</title>

<style>
body{background:#ddd;font-family:Inter;}

.container{
width:60%;margin:50px auto;
background:#f7d63b;padding:30px;
border-radius:10px;
}

input,select{
width:100%;padding:10px;margin:10px 0;
border:none;border-radius:5px;
}

button{
background:#2f4f1e;color:white;
padding:10px;border:none;
border-radius:5px;
}
</style>
</head>

<body>

<div class="container">
<h2>Tambah User Baru</h2>

<form method="POST">
Nama<input type="text" name="nama">
Username<input type="text" name="username">
Password<input type="text" name="password">

Role
<select name="role">
<option>Petugas</option>
<option>Admin</option>
</select>

<button name="simpan">Simpan</button>
</form>
</div>

<?php
if(isset($_POST['simpan'])){
mysqli_query($koneksi,"INSERT INTO users VALUES(NULL,'$_POST[username]','$_POST[password]','$_POST[nama]','$_POST[role]')");
header("location:data_user.php");
}
?>