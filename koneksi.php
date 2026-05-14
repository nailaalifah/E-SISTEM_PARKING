<?php
$koneksi = mysqli_connect("localhost","root","","sistem_parkir");
if( mysqli_connect_errno()) {
    echo "koneksi  databsae gagal : " .mysqli_connect_error();
}

date_default_timezone_set('Asia/Jakarta');
mysqli_query($koneksi, "SET time_zone = '+07:00'");
?>