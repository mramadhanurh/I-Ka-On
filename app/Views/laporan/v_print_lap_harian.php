<div class="col-12">
    <b>Tanggal :</b> <?= $tgl ?>
    <table class="table table-bordered table-striped">
        <tr class="text-center">
            <th class="text-center">No</th>
            <th class="text-center">Kode Produk</th>
            <th>Nama Produk</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Harga</th>
        </tr>
        <?php $no = 1;
        foreach ($dataharian as $row) { ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= $row['id_produk'] ?></td>
                <td><?= $row['nama_produk'] ?></td>
                <td class="text-center"><?= $row['qty'] ?></td>
                <td class="text-center"><?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
            </tr>
        <?php } ?>
    </table>
</div>