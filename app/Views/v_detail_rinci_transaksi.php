<div class="col-md-12">
    <div class="card card-pink">
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
                    <th>Nama Lengkap</th>
                    <td><?= $transaksi['nama_lengkap']; ?></td>
                </tr>
                <tr>
                    <th>No Telpon/WA</th>
                    <td>
                        <a href="https://wa.me/62<?= substr($transaksi['no_telpon'], 1) ?>?text=Halo%20Saya%20Admin,%20Ingin%20Follow%20Up%20Pesanan%20ya%20kak" target="_blank">
                            <?= $transaksi['no_telpon']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Kota</th>
                    <td><?= $transaksi['kota']; ?></td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td><?= $transaksi['kecamatan']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td><?= date('d-m-Y', strtotime($transaksi['tgl_transaksi'])) ?></td>
                </tr>
                <tr>
                    <th>Pengiriman</th>
                    <td>
                        <?php if ($transaksi['pengiriman'] == 1): ?>
                            <span class="badge badge-primary">Datang ke Toko</span>
                        <?php elseif ($transaksi['pengiriman'] == 2): ?>
                            <span class="badge badge-success">GrabExpress</span>
                        <?php elseif ($transaksi['pengiriman'] == 3): ?>
                            <span class="badge badge-success">Gosend</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Grand Total</th>
                    <td><?= $transaksi['grand_total']; ?></td>
                </tr>
                <tr>
                    <th>Status Transaksi</th>
                    <td>
                        <?php if ($transaksi['status_transaksi'] == 0): ?>
                            <span class="badge badge-primary">Konfirmasi</span>
                        <?php elseif ($transaksi['status_transaksi'] == 1): ?>
                            <span class="badge badge-success">Proses</span>
                        <?php elseif ($transaksi['status_transaksi'] == 2): ?>
                            <span class="badge badge-info">Selesai</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Alamat Lengkap</th>
                    <td><?= $transaksi['alamat_lengkap']; ?></td>
                </tr>
                <tr>
                    <th>Bukti Transaksi</th>
                    <td>
                        <?php if (!empty($transaksi['bukti_transaksi'])) : ?>
                            <a href="<?= base_url('bukti_transaksi/' . $transaksi['bukti_transaksi']) ?>" target="_blank">
                                <img src="<?= base_url('bukti_transaksi/' . $transaksi['bukti_transaksi']) ?>" alt="Bukti Transaksi" width="100">
                            </a>
                        <?php else : ?>
                            <span class="text-danger">Belum Upload</span>
                        <?php endif; ?>
                    </td>
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