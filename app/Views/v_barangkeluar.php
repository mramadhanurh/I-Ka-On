<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>

            <div class="card-tools">
                <a href="<?= base_url('BarangKeluar/exportExcel'); ?>" class="btn btn-success btn-tool">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>

                <a href="<?= base_url('BarangKeluar/create') ?>" type="button" class="btn btn-tool"><i class="fas fa-plus"></i> Add Data
                </a>
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
                        <th width="20px">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tanggal</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($barangkeluar as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $value['kode_produk'] ?></td>
                            <td><?= $value['nama_produk'] ?></td>
                            <td class="text-center"><?= $value['nama_satuan'] ?></td>
                            <td class="text-right">Rp. <?= number_format($value['harga_jual'], 0) ?></td>
                            <td class="text-center"><?= $value['stok'] ?></td>
                            <td class="text-center"><?= $value['tanggal'] ?></td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_barangkeluar'] ?>"><i class="fas fa-trash"></i></button>
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
<?php foreach ($barangkeluar as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_barangkeluar'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Data <?= $subjudul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Hapus <b><?= $value['nama_produk'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('BarangKeluar/DeleteData/' . $value['id_barangkeluar']) ?>" class="btn btn-danger btn-flat">Delete</a>
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