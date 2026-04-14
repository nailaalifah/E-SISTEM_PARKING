<?php
$koneksi = mysqli_connect("localhost","root","","sistem_parkir");
if( mysqli_connect_errno()) {
    echo "koneksi  databsae gagal : " .mysqli_connect_error();
}
?>