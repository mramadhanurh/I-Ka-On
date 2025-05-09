<div class="col-12">
    <b>Tahun :</b> <?= $tahun ?>
    <table class="table table-bordered table-striped">
        <tr class="text-center">
            <th>Bulan</th>
            <th>Total Qty</th>
            <th>Total Harga</th>
        </tr>
        <?php foreach ($datatahunan as $data) : ?>
            <tr>
                <td class="text-center"><?= $data['bulan'] ?></td>
                <td class="text-center"><?= $data['qty'] ?></td>
                <td class="text-center"><?= number_format($data['grand_total'], 0, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>