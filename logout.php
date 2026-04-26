<?php 
session_start(); // Memulai session agar bisa dihapus
session_destroy(); // Menghapus semua data login (username, level, dll)

// Mengarahkan kembali ke halaman login yang berada di folder yang sama
header("location:login.php?pesan=logout");
exit();
?>