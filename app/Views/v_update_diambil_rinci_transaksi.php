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

            <form action="<?= base_url('Pesanan/saveUpdateDataDiambil/' . $transaksi['id_transaksi']); ?>" method="post">
                <?= csrf_field(); ?>

                <!-- Update Status Diambil -->
                <div class="form-group">
                    <label>Status Diambil</label>
                    <select name="status_diambil" class="form-control">
                        <option value="0" <?= ($transaksi['status_diambil'] == 0) ? 'selected' : ''; ?>>Belum Diambil</option>
                        <option value="1" <?= ($transaksi['status_diambil'] == 1) ? 'selected' : ''; ?>>Sudah Diambil</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>