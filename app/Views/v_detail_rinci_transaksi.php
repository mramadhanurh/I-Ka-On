<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>

            <div class="card-tools">
                <a href="<?= base_url('Pesanan/exportExcelDetailTransaksi/' . $transaksi['id_transaksi']); ?>" class="btn btn-success btn-tool">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>

            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <!-- Detail Transaksi -->
            <h4>Detail Transaksi</h4>
            <table class="table table-bordered">
                <tr>
                    <th>No Order</th>
                    <td><?= $transaksi['no_order']; ?></td>
                </tr>
                <tr>
                    <th>Nama Transaksi</th>
                    <td><?= $transaksi['nama_transaksi']; ?></td>
                </tr>
                <tr>
                    <th>NRP</th>
                    <td><?= $transaksi['nrp']; ?></td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>
                        <a href="https://wa.me/62<?= substr($transaksi['no_hp'], 1) ?>?text=Halo%20Saya%20Admin,%20Ingin%20Follow%20Up%20Pesanan%20ya%20kak" target="_blank">
                            <?= $transaksi['no_hp']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td><?= $transaksi['dept']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td><?= date('d-m-Y', strtotime($transaksi['tgl_transaksi'])) ?></td>
                </tr>
                <tr>
                    <th>Grand Total</th>
                    <td><?= $transaksi['grand_total']; ?></td>
                </tr>
                <tr>
                    <th>Status Transaksi</th>
                    <td>
                        <?= ($transaksi['status_transaksi'] == 0) ? '<span class="badge bg-danger">Belum Konfirmasi</span>' : '<span class="badge bg-success">Sudah Konfirmasi</span>'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td><?= $transaksi['keterangan']; ?></td>
                </tr>
            </table>

            <br><br>
            <!-- Rincian Transaksi -->
            <h4>Rincian Produk</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($rinciTransaksi as $rinci) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $rinci['nama_produk']; ?></td>
                            <td class="text-center"><?= $rinci['nama_satuan']; ?></td>
                            <td class="text-center"><?= $rinci['qty']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>