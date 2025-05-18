<div class="col-md-12">
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>

            <div class="card-tools">
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <form action="<?= base_url('Pesanan/saveUpdateData/' . $transaksi['id_transaksi']); ?>" method="post">
                <?= csrf_field(); ?>

                <!-- Update Status Transaksi -->
                <div class="form-group">
                    <label>Status Transaksi</label>
                    <select name="status_transaksi" class="form-control">
                        <option value="0" <?= ($transaksi['status_transaksi'] == 0) ? 'selected' : ''; ?>>Belum Konfirmasi</option>
                        <option value="1" <?= ($transaksi['status_transaksi'] == 1) ? 'selected' : ''; ?>>Sudah Konfirmasi</option>
                    </select>
                </div>

                <!-- Update Quantity dan otomatis kurangi stok -->
                <h4>Update Rincian Produk</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Qty Lama</th>
                            <th>Qty Baru</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rinciTransaksi as $rinci) : ?>
                            <tr>
                                <td class="text-center"><?= $rinci['id_produk']; ?></td>
                                <td><?= $rinci['nama_produk']; ?></td>
                                <td class="text-center"><?= $rinci['qty']; ?></td>
                                <td>
                                    <input type="number" name="rinci[<?= $rinci['id_rinci']; ?>]" value="<?= $rinci['qty']; ?>" min="0" class="form-control">
                                </td>
                                <td class="text-center"><?= $rinci['stok']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>