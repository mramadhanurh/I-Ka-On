<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-success"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Stok Tersedia</span>
            <span class="info-box-number"><?= $jml_status_tersedia ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- ./col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Stok Rendah</span>
            <span class="info-box-number"><?= $jml_status_rendah ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- ./col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Stok Habis</span>
            <span class="info-box-number"><?= $jml_status_habis ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- ./col -->

<div class="col-md-12">
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>

            <div class="card-tools">
                <a href="<?= base_url('Produk/exportExcel'); ?>" class="btn btn-success btn-tool">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>

                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#add-data"><i class="fas fa-plus"></i> Add Data
                </button>
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

            <?php
            $errors = session()->getFlashdata('errors');
            if (!empty($errors)) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <h4>Periksa Lagi Isian Produk!</h4>
                    <ul>
                        <?php foreach ($errors as $key => $error) { ?>
                            <li><?= esc($error) ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <form method="get" action="<?= base_url('produk') ?>" class="form-inline mb-3">
                <label class="mr-2">Filter Status:</label>
                <select name="status" class="form-control mr-2">
                    <option value="">-- Semua --</option>
                    <option value="1" <?= @$_GET['status'] == 1 ? 'selected' : '' ?>>Stok Tersedia</option>
                    <option value="2" <?= @$_GET['status'] == 2 ? 'selected' : '' ?>>Stok Rendah</option>
                    <option value="3" <?= @$_GET['status'] == 3 ? 'selected' : '' ?>>Stok Habis</option>
                </select>
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </form>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th width="20px">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($produk as $key => $value) { ?>
                        <tr class="<?= $value['stok'] == 0 ? 'bg-danger' : '' ?>">
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $value['kode_produk'] ?></td>
                            <td><?= $value['nama_produk'] ?></td>
                            <td class="text-center"><?= $value['nama_kategori'] ?></td>
                            <td class="text-center"><?= $value['nama_satuan'] ?></td>
                            <td class="text-right">Rp. <?= number_format($value['harga_beli'], 0) ?></td>
                            <td class="text-right">Rp. <?= number_format($value['harga_jual'], 0) ?></td>
                            <td class="text-center"><?= $value['stok'] ?></td>
                            <td class="text-center">
                                <?php if ($value['status'] == 1): ?>
                                    <span class="badge badge-success">Stok Tersedia</span>
                                <?php elseif ($value['status'] == 2): ?>
                                    <span class="badge badge-warning">Stok Rendah</span>
                                <?php elseif ($value['status'] == 3): ?>
                                    <span class="badge badge-danger">Stok Habis</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Status Tidak Diketahui</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center" width="70px"><img src="<?= base_url('foto/' . $value['gambar_produk']) ?>" width="70px"></td>
                            <td class="text-center">
                                <a href="<?= base_url('produk/warna/' . $value['id_produk']) ?>" class="btn btn-success btn-sm btn-flat">
                                    <i class="fas fa-palette"></i>
                                </a>
                                <a href="<?= base_url('produk/gambar/' . $value['id_produk']) ?>" class="btn btn-primary btn-sm btn-flat">
                                    <i class="fas fa-images"></i>
                                </a>
                                <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_produk'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_produk'] ?>"><i class="fas fa-trash"></i></button>
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

<!-- Modal Add Data -->
<div class="modal fade" id="add-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Data <?= $subjudul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('Produk/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Kode Produk</label>
                            <input name="kode_produk" class="form-control" value="<?= old('kode_produk') ?>" placeholder="Kode Produk" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Nama Produk</label>
                            <input name="nama_produk" class="form-control" value="<?= old('nama_produk') ?>" placeholder="Nama Produk" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="id_kategori" class="form-control">
                                <option value="">--Pilih Kategori--</option>
                                <?php foreach ($kategori as $key => $value) { ?>
                                    <option value="<?= $value['id_kategori'] ?>"><?= $value['nama_kategori'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Satuan</label>
                            <select name="id_satuan" class="form-control">
                                <option value="">--Pilih Satuan--</option>
                                <?php foreach ($satuan as $key => $value) { ?>
                                    <option value="<?= $value['id_satuan'] ?>"><?= $value['nama_satuan'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Harga Beli</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input name="harga_beli" id="harga_beli" value="<?= old('harga_beli') ?>" class="form-control" placeholder="Harga Beli" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Harga Jual</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input name="harga_jual" id="harga_jual" value="<?= old('harga_jual') ?>" class="form-control" placeholder="Harga Jual" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Stok</label>
                            <input name="stok" type="number" value="<?= old('stok') ?>" class="form-control" placeholder="Stok" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Upload Foto</label>
                            <input type="file" name="gambar_produk" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" selected>Stok Tersedia</option>
                                <option value="2">Stok Rendah</option>
                                <option value="3">Stok Habis</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php foreach ($produk as $key => $value) { ?>
    <!-- Modal Edit Data -->
    <div class="modal fade" id="edit-data<?= $value['id_produk'] ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data <?= $subjudul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open_multipart('Produk/UpdateData/' . $value['id_produk']) ?>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Kode Produk</label>
                                <input name="kode_produk" class="form-control" value="<?= $value['kode_produk'] ?>" placeholder="Kode Produk" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Nama Obat</label>
                                <input name="nama_produk" class="form-control" value="<?= $value['nama_produk'] ?>" placeholder="Nama Obat" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select name="id_kategori" class="form-control">
                                    <option value="">--Pilih Kategori--</option>
                                    <?php foreach ($kategori as $key => $k) { ?>
                                        <option value="<?= $k['id_kategori'] ?>" <?= $value['id_kategori'] == $k['id_kategori'] ? 'Selected' : '' ?>><?= $k['nama_kategori'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <select name="id_satuan" class="form-control">
                                    <option value="">--Pilih Satuan--</option>
                                    <?php foreach ($satuan as $key => $s) { ?>
                                        <option value="<?= $s['id_satuan'] ?>" <?= $value['id_satuan'] == $s['id_satuan'] ? 'Selected' : '' ?>><?= $s['nama_satuan'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Harga Beli</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input name="harga_beli" id="harga_beli<?= $value['id_produk'] ?>" value="<?= $value['harga_beli'] ?>" class="form-control" placeholder="Harga Beli" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Harga Jual</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input name="harga_jual" id="harga_jual<?= $value['id_produk'] ?>" value="<?= $value['harga_jual'] ?>" class="form-control" placeholder="Harga Jual" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Stok</label>
                                <input name="stok" type="number" value="<?= $value['stok'] ?>" class="form-control" placeholder="Stok" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Upload Foto</label>
                                <input type="file" name="gambar_produk" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" <?= $value['status'] == 1 ? 'Selected' : '' ?>>Stok Tersedia</option>
                                    <option value="2" <?= $value['status'] == 2 ? 'Selected' : '' ?>>Stok Rendah</option>
                                    <option value="3" <?= $value['status'] == 3 ? 'Selected' : '' ?>>Stok Habis</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-flat">Update</button>
                </div>
                <?= form_close() ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>

<!-- Modal Delete Data -->
<?php foreach ($produk as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_produk'] ?>">
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
                    <a href="<?= base_url('Produk/DeleteData/' . $value['id_produk']) ?>" class="btn btn-danger btn-flat">Delete</a>
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

    new AutoNumeric('#harga_beli', {
        digitGroupSeparator: ',',
        decimalPlaces: 0,
    });

    new AutoNumeric('#harga_jual', {
        digitGroupSeparator: ',',
        decimalPlaces: 0,
    });

    <?php foreach ($produk as $key => $value) { ?>
        new AutoNumeric('#harga_beli<?= $value['id_produk'] ?>', {
            digitGroupSeparator: ',',
            decimalPlaces: 0,
        });

        new AutoNumeric('#harga_jual<?= $value['id_produk'] ?>', {
            digitGroupSeparator: ',',
            decimalPlaces: 0,
        });
    <?php } ?>
</script>
