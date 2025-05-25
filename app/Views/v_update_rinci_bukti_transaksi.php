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

            <div class="row">
                <h4>Silahkan melakukan pembayaran pada bank dibawah ini :</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Bank</th>
                            <th class="text-center">Atas Nama</th>
                            <th class="text-center">No Rekening</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bankrekening as $rinci) : ?>
                            <tr>
                                <td class="text-center"><?= $rinci['nama_rekening']; ?></td>
                                <td><?= $rinci['atas_nama']; ?></td>
                                <td class="text-center"><?= $rinci['no_rekening']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <hr>

            <form action="<?= base_url('Pesananuser/saveUpdateData/' . $transaksi['id_transaksi']); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <!-- Update Uploud Bukti Transaksi -->
                <div class="form-group">
                    <label>Uploud Bukti Transaksi</label>
                    <input type="file" name="bukti_transaksi" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>