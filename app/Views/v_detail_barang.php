<div class="card card-solid">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3 class="d-inline-block d-sm-none"></h3>
                <div class="col-12">
                    <img src="<?= base_url('foto/' . $produk->gambar_produk) ?>" class="product-image" alt="Product Image">
                </div>
                <div class="col-12 product-image-thumbs">
                    <div class="product-image-thumb active"><img src="<?= base_url('foto/' . $produk->gambar_produk) ?>" alt="Product Image"></div>
                    <?php foreach ($gambar as $key => $value) { ?>
                        <div class="product-image-thumb" ><img src="<?= base_url('foto/' . $value->nama_file) ?>" alt="Product Image"></div>
                    <?php } ?>
                    
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <h3 class="my-3"><?= $produk->nama_produk ?></h3>
                <h5>Kategori <?= $produk->nama_kategori ?></h5>

                <hr>

                <?php
                echo form_open('belanja/add');
                echo form_hidden('id', $produk->id_produk);
                echo form_hidden('price', $produk->harga_jual);
                echo form_hidden('name', $produk->nama_produk);
                echo form_hidden('gambar_produk', $produk->gambar_produk);
                echo form_hidden('nama_satuan', $produk->nama_satuan);
                echo form_hidden('redirect_page', str_replace('index.php/', '', current_url()));
                ?>
                <div class="bg-gray py-2 px-3 mt-4">
                    <h2 class="mb-0">
                        Rp <?= number_format($produk->harga_jual, 0) ?>
                    </h2>
                </div>
                <div class="mt-1">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if ($warna) { ?>
                                <div class="mt-3">
                                    <label>Pilih Warna :</label>
                                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                                        <?php foreach ($warna as $key => $value) { ?>
                                            <label class="btn btn-outline-info btn-sm m-1">
                                                <input type="radio" name="warna" value="<?= $value['id_warna'] ?>" autocomplete="off"> <?= $value['nama_warna'] ?>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-2">
                            <input type="number" name="qty" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary btn-flat swalDefaultSuccess" id="btn-add-to-cart">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>
        </div>
        <div class="row mt-4">
            
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->



<!-- SweetAlert2 -->
<script src="<?= base_url('AdminLTE') ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    const isLoggedIn = <?= session()->get('id_user') ? 'true' : 'false' ?>;

    $(document).ready(function() {
        $('.product-image-thumb').on('click', function () {
        var $image_element = $(this).find('img')
        $('.product-image').prop('src', $image_element.attr('src'))
        $('.product-image-thumb.active').removeClass('active')
        $(this).addClass('active')
        })
    });

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
                title: 'Barang Berhasil Ditambahkan Ke Keranjang!'
            })
        });
    });

    document.getElementById('btn-add-to-cart').addEventListener('click', function(e) {
        if (!isLoggedIn) {
            e.preventDefault();
            alert('Silakan login terlebih dahulu!');
            window.location.href = "<?= base_url('home') ?>";
        }
    });
</script>