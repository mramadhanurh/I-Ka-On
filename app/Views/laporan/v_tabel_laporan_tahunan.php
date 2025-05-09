<div class="row">
    <div class="col-12 text-center">

        <address>
            <i class="fas fa-shopping-cart fa-3x text-primary"></i>
            <font size=9 class="text-primary"><?= $web['nama_toko'] ?></font><br>
            <strong class="text-primary"><?= $web['slogan'] ?></strong><br>
            <strong><?= $web['alamat'] ?></strong><br>
        </address>
    </div>
    <div class="col-12 text-center">
        <hr>
        <b>
            <h4><?= $judul ?></h4>
        </b>
    </div>

    <div class="col-12">
        <b>Tahun :</b> <?= $tahun ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>Bulan</th>
                    <th>Total Qty</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datatahunan as $data) : ?>
                    <tr>
                        <td class="text-center"><?= $data['bulan'] ?></td>
                        <td class="text-center"><?= $data['qty'] ?></td>
                        <td class="text-center"><?= number_format($data['grand_total'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>