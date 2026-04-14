<div class="top-header" style="background: linear-gradient(90deg, #F2EDC2 0%, #FFFFFF 100%); width: 100%; height: 80px; display: flex; align-items: center; padding: 0 30px; box-sizing: border-box;">
    <h1 style="margin: 0; font-size: 2rem; font-weight: bold; color: #000;">Dashboard Admin</h1>
    <img src="../assets/logo.png" style="height: 60px; margin-left: auto;">
</div>

<div class="content-body" style="padding: 30px; background: transparent;">
    
    <div class="cards-container" style="display: flex; gap: 20px; margin-bottom: 50px;">
        
        <div class="card" style="flex: 1; background: #F2EDC2; border-radius: 20px; padding: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-bottom: 15px solid #4C5C2D; position: relative;">
            <p style="margin: 0; font-weight: bold;">Total Kendaraan<br>Hari Ini</p>
            <h2 style="font-size: 4rem; text-align: center; margin: 10px 0; color: #D4A017;"><?= $total_hari_ini ?></h2>
            <span style="position: absolute; top: 20px; right: 20px; font-size: 1.5rem;">🏍️</span>
        </div>

        <div class="card" style="flex: 1; background: #F2EDC2; border-radius: 20px; padding: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-bottom: 15px solid #4C5C2D; position: relative;">
            <p style="margin: 0; font-weight: bold;">Kendaraan Masih<br>Parkir</p>
            <h2 style="font-size: 4rem; text-align: center; margin: 10px 0; color: #D4A017;"><?= $masih_parkir ?></h2>
            <span style="position: absolute; top: 20px; right: 20px; font-size: 1.5rem;">🛵</span>
        </div>

        <div class="card" style="flex: 1; background: #F2EDC2; border-radius: 20px; padding: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-bottom: 15px solid #4C5C2D; position: relative;">
            <p style="margin: 0; font-weight: bold;">Total Pendapatan</p>
            <h2 style="font-size: 2.5rem; text-align: center; margin: 25px 0; color: #D4A017;">Rp <?= number_format($pendapatan, 0, ',', '.') ?></h2>
            <span style="position: absolute; top: 20px; right: 20px; font-size: 1.5rem;">💼</span>
        </div>

    </div>

    <h3 style="margin-bottom: 15px;">Riwayat Transaksi Hari Ini</h3>
    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden;">
        <thead style="background: #4C5C2D; color: white;">
            <tr>
                <th style="padding: 15px;">ID Transaksi</th>
                <th>Kode Tiket</th>
                <th>Plat Nomor</th>
                <th>Jenis Kendaraan</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            </tbody>
    </table>
</div>