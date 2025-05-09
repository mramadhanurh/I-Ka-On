<div class="col-12">
    <b>Bulan :</b> <?= $bulan ?> <b>Tahun :</b> <?= $tahun ?>
    <table class="table table-bordered table-striped">
        <tr class="text-center">
            <th class="text-center">No</th>
            <th class="text-center">Tanggal Transaksi</th>
            <th class="text-center">Total Qty</th>
            <th class="text-center">Grand Total</th>
        </tr>
        <?php $no = 1;
        foreach ($databulanan as $data) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($data['tgl_transaksi'])); ?></td>
                <td class="text-center"><?= $data['total_qty']; ?></td>
                <td class="text-center"><?= number_format($data['total_grand'], 0, ',', '.'); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>