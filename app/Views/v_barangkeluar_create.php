<div class="col-md-12">
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>

            <!-- /.card-tools -->
        </div>

        <?php echo form_open('BarangKeluar/create') ?>
        <div class="card-body">
            <div class="row">
                <div class="col-12">

                    <!-- Select Produk -->
                    <div class="form-group">
                        <label for="id_produk">Nama Produk</label>
                        <select id="id_produk" name="id_produk" class="form-control" required onchange="updateForm()">
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($produk as $p) : ?>
                                <option value="<?= $p['id_produk']; ?>" data-kode="<?= $p['kode_produk']; ?>" data-harga="<?= $p['harga_jual']; ?>">
                                    <?= $p['nama_produk']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Input Kode Produk (Read-Only) -->
                    <div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input type="text" class="form-control" id="kode_produk" name="kode_produk" readonly>
                    </div>

                    <!-- Input Harga Jual (Read-Only) -->
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" readonly>
                    </div>

                    <!-- Input Stok Keluar -->
                    <div class="form-group">
                        <label for="stok">Stok Keluar</label>
                        <input type="number" min="0" id="stok" name="stok" class="form-control" required>
                    </div>

                    <!-- Input Tanggal -->
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <?php echo form_close() ?>

    </div>
    <!-- /.card -->
</div>
<!-- /.col -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function updateForm() {
        // Ambil elemen select
        var select = document.getElementById('id_produk');
        // Ambil pilihan yang dipilih
        var selectedOption = select.options[select.selectedIndex];

        // Update kode produk dan harga jual berdasarkan atribut dari pilihan yang dipilih
        document.getElementById('kode_produk').value = selectedOption.getAttribute('data-kode');
        document.getElementById('harga_jual').value = selectedOption.getAttribute('data-harga');
    }

    $(document).ready(function() {
        $('#id_produk').select2({
            placeholder: "Pilih Produk",
            theme : "bootstrap4",
        });
    });
</script>