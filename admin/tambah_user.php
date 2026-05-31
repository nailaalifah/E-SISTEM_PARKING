<?php 
    include '../koneksi.php'; 
?>
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
        box-sizing: border-box; /* Mencegah input melebar keluar container */
        }

        /* Mengatur posisi tombol simpan dan kembali agar sejajar ke samping */
        .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        }

        button, .btn-kembali{
        padding:10px 20px;border:none;
        border-radius:5px;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        display: inline-block;
        }

        button{
        background:#2f4f1e;color:white;
        }

        /* Warna abu-abu untuk tombol kembali sesuai dengan tema halaman cetakmu */
        .btn-kembali{
        background:#ccc;color:black;
        }
        </style>
        </head>

    <body>

    <div class="container">
    <h2>Tambah User Baru</h2>

    <form method="POST">
    Nama<input type="text" name="nama" required>
    Username<input type="text" name="username" required>
    Password<input type="text" name="password" required>

    Role
    <select name="role" required>
    <option value="2">Petugas</option>
    <option value="1">Admin</option>
    </select>

    <div class="btn-group">
        <button name="simpan">Simpan</button>
        <a href="data_user.php" class="btn-kembali">Kembali</a>
    </div>
    </form>
    </div>

    <?php
    if(isset($_POST['simpan'])){
    mysqli_query($koneksi,"INSERT INTO t_user VALUES(NULL,'$_POST[username]','$_POST[password]','$_POST[nama]','$_POST[role]')");
    header("location:data_user.php");
    }
    ?>