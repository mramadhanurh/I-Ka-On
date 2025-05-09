<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>

            <div class="card-tools">

                <a href="<?= base_url('Pesanan/exportExcel'); ?>" class="btn btn-success btn-tool">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>

                <!-- <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#add-data"><i class="fas fa-plus"></i> Add Data
                </button> -->
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
                        <th>Tanggal</th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Dept</th>
                        <th>Status Konfirmasi</th>
                        <th>Status Diambil</th>
                        <th width="130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pesanan as $key => $value) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y', strtotime($value['tgl_transaksi'])) ?></td>
                            <td><?= $value['nrp'] ?></td>
                            <td class="text-center"><?= $value['nama_transaksi'] ?></td>
                            <td class="text-center"><?= $value['dept'] ?></td>
                            <td class="text-center">
                                <?php if ($value['status_transaksi'] == 0) : ?>
                                    <span class="badge bg-danger">Belum Konfirmasi</span>
                                <?php elseif ($value['status_transaksi'] == 1) : ?>
                                    <span class="badge bg-success">Sudah Konfirmasi</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($value['status_diambil'] == 0) : ?>
                                    <span class="badge bg-danger">Belum Diambil</span>
                                <?php elseif ($value['status_diambil'] == 1) : ?>
                                    <span class="badge bg-success">Sudah Diambil</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                            <a href="<?= base_url('Pesanan/updateDiambil/' . $value['id_transaksi']) ?>" class="btn btn-secondary btn-sm btn-flat"><i class="fas fa-shopping-basket"></i></a>
                                <a href="<?= base_url('Pesanan/DetailData/' . $value['id_transaksi']) ?>" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-eye"></i></a>
                                <a href="<?= base_url('Pesanan/updateData/' . $value['id_transaksi']) ?>" class="btn btn-warning btn-sm btn-flat"><i class="fas fa-pencil-alt"></i></a>
                                <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_transaksi'] ?>"><i class="fas fa-trash"></i></button>
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

<!-- Modal Delete Data -->
<?php foreach ($pesanan as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_transaksi'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Data <?= $subjudul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Ingin Menghapus Transaksi dengan No Order <b><?= $value['no_order'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Pesanan/deleteData/' . $value['id_transaksi']) ?>" class="btn btn-danger btn-flat">Delete</a>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>


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