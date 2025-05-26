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
            <?php
            if (session()->getFlashdata('pesan')) {
                echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('pesan');
                echo '</h5></div>';
            }
            ?>


            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th width="50px">No</th>
                        <th>No Invoice</th>
                        <th>Nama Lengkap</th>
                        <th>Tanggal</th>
                        <th>Pengiriman</th>
                        <th>Status</th>
                        <th width="130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pesanan as $key => $value) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value['no_order'] ?></td>
                            <td><?= $value['nama_lengkap'] ?></td>
                            <td><?= date('d-m-Y', strtotime($value['tgl_transaksi'])) ?></td>
                            <td class="text-center">
                                <?php if ($value['pengiriman'] == 1): ?>
                                    <span class="badge badge-primary">Datang ke Toko</span>
                                <?php elseif ($value['pengiriman'] == 2): ?>
                                    <span class="badge badge-success">GrabExpress</span>
                                <?php elseif ($value['pengiriman'] == 3): ?>
                                    <span class="badge badge-success">Gosend</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($value['status_transaksi'] == 0): ?>
                                    <span class="badge badge-primary">Konfirmasi</span>
                                <?php elseif ($value['status_transaksi'] == 1): ?>
                                    <span class="badge badge-success">Proses</span>
                                <?php elseif ($value['status_transaksi'] == 2): ?>
                                    <span class="badge badge-info">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('Pesananuser/updateRating/' . $value['id_transaksi']) ?>" class="btn btn-warning btn-sm btn-flat"><i class="far fa-star"></i></a>
                                <a href="<?= base_url('Pesananuser/DetailData/' . $value['id_transaksi']) ?>" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-eye"></i></a>
                                <?php if (empty($value['bukti_transaksi'])) : ?>
                                    <a href="<?= base_url('Pesananuser/updateData/' . $value['id_transaksi']) ?>" class="btn btn-info btn-sm btn-flat">
                                        <i class="far fa-file-image"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->



<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "ordering": true,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>