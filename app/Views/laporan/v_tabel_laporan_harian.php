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
        <b>Tanggal :</b> <?= $tgl ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Produk</th>
                    <th>Nama Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($dataharian as $row) { ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $row['id_produk'] ?></td>
                        <td><?= $row['nama_produk'] ?></td>
                        <td class="text-center"><?= $row['qty'] ?></td>
                        <td class="text-center"><?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
