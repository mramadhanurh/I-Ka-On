<?php echo form_open('belanja/update') ?>
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-shopping-cart"></i> Keranjang Belanja.
                <small class="float-right">Date: <?= date('d-m-Y') ?></small>
            </h4>
        </div>
        <!-- /.col -->
    </div>

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="100px">Qty</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Warna</th>
                        <th class="text-center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($cart->contents() as $key => $value) { ?>
                        <tr>
                            <td><input type="number" min="1" name="qty<?= $i++ ?>" class="form-control" value="<?= $value['qty'] ?>"></td>
                            <td><img src="<?= base_url('foto/' . $value['options']['gambar_produk']) ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle"></td>
                            <td><?= $value['name'] ?></td>
                            <td><?= $value['options']['nama_satuan'] ?></td>
                            <td><?= $warnaMap[$value['options']['warna']] ?? '-' ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('belanja/delete/' . $value['rowid']) ?>" class="btn btn-sm btn-danger swalDefaultSuccess"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">

        </div>
        <!-- /.col -->
        <div class="col-4">
            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <button type="submit" class="btn btn-primary swalDefaultSuccess"><i class="fas fa-save"></i> Update</button>
            <a href="<?= base_url('belanja/clear') ?>" class="btn btn-warning swalDefaultSuccess"><i class="fas fa-trash"></i> Clear Keranjang</a>
            <a href="<?= base_url('store/cekout') ?>" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Cek Out
            </a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>


<!-- SweetAlert2 -->
<script src="<?= base_url('AdminLTE') ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('.swalDefaultSuccess').click(function() {
            Toast.fire({
                icon: 'success',
                title: 'Data Barang Berhasil Diupdate Ke Keranjang!'
            })
        });
    });
</script>