<?php
include '../koneksi.php';

$tgl_mulai = $_GET['tgl_mulai'];
$tgl_selesai = $_GET['tgl_selesai'];
$metode = $_GET['metode'];

$where_clause = "WHERE DATE(p.waktu_bayar) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
if ($metode != 'Semua') { $where_clause .= " AND p.metode_pembayaran = '$metode'"; }

// Ambil data untuk tabel
$sql_tabel = "SELECT p.*, pk.plat_nomor, j.nama_jenis 
              FROM t_pembayaran p 
              LEFT JOIN t_parkir pk ON p.id_parkir = pk.id_parkir 
              LEFT JOIN t_jenis_kendaraan j ON pk.id_jenis = j.id_jenis
              $where_clause ORDER BY p.id_pembayaran DESC";
$data = mysqli_query($koneksi, $sql_tabel);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran Parkir</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body onload="window.print()"> <div class="header">
        <h2>LAPORAN PEMBAYARAN E-PARKING</h2>
        <p>Periode: <?= $tgl_mulai ?> s/d <?= $tgl_selesai ?> | Metode: <?= $metode ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Tiket</th>
                <th>Plat Nomor</th>
                <th>Jenis</th>
                <th>Metode</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            while($row = mysqli_fetch_assoc($data)): 
                // Logika Pemasukan seperti yang kita bahas tadi
                $pemasukan_baris = ($row['kembalian'] < 0) ? $row['jumlah_bayar'] : ($row['jumlah_bayar'] - $row['kembalian']);
                $total += $pemasukan_baris;
            ?>
            <tr>
                <td><?= $row['id_pembayaran'] ?></td>
                <td><?= $row['id_parkir'] ?></td>
                <td><?= $row['plat_nomor'] ?></td>
                <td><?= $row['nama_jenis'] ?></td>
                <td><?= $row['metode_pembayaran'] ?></td>
                <td>Rp <?= number_format($row['jumlah_bayar'],0,',','.') ?></td>
                <td>Rp <?= number_format($row['kembalian'],0,',','.') ?></td>
                <td><?= date('d/m H:i', strtotime($row['waktu_bayar'])) ?></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <th colspan="6">TOTAL PEMASUKAN BERSIH</th>
                <th colspan="3">Rp <?= number_format($total,0,',','.') ?></th>
            </tr>
        </tbody>
    </table>

</body>
</html>