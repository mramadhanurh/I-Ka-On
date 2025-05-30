<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-indigo"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Produk</span>
            <span class="info-box-number"><?= $jml_produk ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- ./col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-teal"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Kategori</span>
            <span class="info-box-number"><?= $jml_kategori ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- ./col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-primary"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Satuan</span>
            <span class="info-box-number"><?= $jml_satuan ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- ./col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-pink"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">User</span>
            <span class="info-box-number"><?= $jml_user ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>

<div class="col-md-12">
    <canvas id="myChart" width="100" height="35px"></canvas>
</div>

<?php
if ($grafik == null) {
    $tgl[] = 0;
    $total[] = 0;
    $untung[] = 0;
} else {
    foreach ($grafik as $key => $value) {
        $tgl[] = $value['tgl_jual'];
        $total[] = $value['total_harga'];
        $untung[] = $value['untung'];
    }
}
?>

<script>
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($tgl) ?>,
            datasets: [{
                    label: 'Grafik Pendapatan Penjualan Bulan <?= date('M Y') ?>',
                    data: <?= json_encode($total) ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 3
                },
                {
                    label: 'Grafik Keuntungan Penjualan Bulan <?= date('M Y') ?>',
                    data: <?= json_encode($untung) ?>,
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 3
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>