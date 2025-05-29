<div class="col-12">
    <b>Tanggal :</b> <?= $tgl ?>
    <table class="table table-bordered table-striped">
        <tr class="text-center">
            <th class="text-center">No</th>
            <th class="text-center">Kode Produk</th>
            <th>Nama Produk</th>
            <th class="text-center">Nama Satuan</th>
            <th class="text-center">Harga Jual</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Tanggal</th>
        </tr>
        <?php $no = 1;
        foreach ($datastokkeluarproduk as $row) { ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= esc($row['kode_produk']) ?></td>
                <td><?= esc($row['nama_produk']) ?></td>
                <td class="text-center"><?= esc($row['nama_satuan']) ?></td>
                <td class="text-center"><?= number_format($row['harga_jual'], 0) ?></td>
                <td class="text-center"><?= esc($row['stok']) ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
            </tr>
        <?php } ?>
    </table>
</div>