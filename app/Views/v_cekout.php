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
                        <th width="100px" class="text-center">Qty</th>
                        <th class="text-center">Gambar</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($cart->contents() as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><?= $value['qty'] ?></td>
                            <td class="text-center"><img src="<?= base_url('foto/' . $value['options']['gambar_produk']) ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle"></td>
                            <td class="text-center"><?= $value['name'] ?></td>
                            <td class="text-center"><?= $value['options']['nama_satuan'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    

    <?php
        if (session()->getFlashdata('pesan')) {
            echo '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i>';
            echo session()->getFlashdata('pesan');
            echo '</h5>';
            // Menyisipkan kalimat "Silahkan lakukan konfirmasi pada tombol wa berikut ini"
            echo '<p>Silahkan lakukan konfirmasi pada tombol wa berikut ini</p>';
            
            // Menyisipkan tombol WhatsApp dengan pesan konfirmasi
            $phoneNumber = '+6281703782407'; // Ganti dengan nomor WhatsApp tujuan
            $message = urlencode('Halo kak, aku mau konfirmasi pesanan kak'); // Encode pesan agar sesuai dengan URL
            $waUrl = 'https://api.whatsapp.com/send?phone=' . $phoneNumber . '&text=' . $message;
            
            echo '<a href="' . $waUrl . '" target="_blank" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> Konfirmasi WhatsApp
                </a>';
            echo '</div>';
        }
    ?>

    <?php
    $errors = session()->getFlashdata('errors');
    if (!empty($errors)) { ?>
        <div class="alert alert-danger alert-dismissible">
            <h4>Periksa Lagi Isian Order Barang!</h4>
            <ul>
                <?php foreach ($errors as $key => $error) { ?>
                    <li><?= esc($error) ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php
    helper('text');
    echo form_open('store/cekout');
    $no_order = date('Ymd') . strtoupper(random_string('alnum', 8));

    ?>
    <div class="row">
        <!-- accepted payments column -->
        <div class="col-sm-8 invoice-col">
            Order Barang :
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="nama_transaksi" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>NRP</label>
                        <input name="nrp" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>No Hp</label>
                        <input name="no_hp" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Dept</label>
                        <select name="dept" class="form-control">
                            <option value="">--Pilih Dept--</option>
                            <option value="HCGS">HCGS</option>
                            <option value="Operation">Operation</option>
                            <option value="Logistic">Logistic</option>
                            <option value="Plant">Plant</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Produksi">Produksi</option>
                            <option value="SHE">SHE</option>
                            <option value="TDC">TDC</option>
                            <option value="SO">SO</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" cols="100" rows="5"></textarea>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-4">
            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Simpan Transaksi -->
    <input name="no_order" value="<?= $no_order ?>" hidden>
    <input name="grand_total" value="<?= $cart->total() ?>" hidden>
    <!-- end Simpan Transaksi -->

    <!-- Simpan Rinci Transaksi -->
    <?php
    $i = 1;
    foreach ($cart->contents() as $items) {
        echo form_hidden('qty' . $i++, $items['qty']);
    }

    ?>
    <!-- end Simpan Rinci Transaksi -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <a href="<?= base_url('store/cart') ?>" class="btn btn-warning"><i class="fas fa-backward"></i> Kembali Ke Keranjang</a>
            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-shopping-cart"></i> Proses Cekout
            </button>
        </div>
    </div>

    <?php echo form_close() ?>
</div>