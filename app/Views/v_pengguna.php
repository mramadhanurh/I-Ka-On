<div class="col-md-4">
    <!-- Info Boxes Style 2 -->
    <div class="info-box mb-3 bg-primary">
        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Transaksi Hari Ini</span>
            <span class="info-box-number">Rp <?= number_format($transaksi_hari_ini, 0, ',', '.') ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
</div>

<div class="col-md-4">
    <!-- Info Boxes Style 2 -->
    <div class="info-box mb-3 bg-indigo">
        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Transaksi Bulan Ini</span>
            <span class="info-box-number">Rp <?= number_format($transaksi_bulan_ini, 0, ',', '.') ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
</div>

<div class="col-md-4">
    <!-- Info Boxes Style 2 -->
    <div class="info-box mb-3 bg-fuchsia">
        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Transaksi Tahun Ini</span>
            <span class="info-box-number">Rp <?= number_format($transaksi_tahun_ini, 0, ',', '.') ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
</div>