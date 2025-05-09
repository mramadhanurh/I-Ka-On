<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <!-- <ol class="carousel-indicators"> -->
    <!-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
    <!-- </ol> -->
    <div class="carousel-inner">
        <?php foreach ($slider as $key => $value) { ?>
            <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                <img class="d-block w-100" src="<?= base_url('gambar_slider/' . $value['gambar_slider']) ?>">
            </div>
        <?php } ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-custom-icon" aria-hidden="true">
            <i class="fas fa-chevron-left"></i>
        </span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-custom-icon" aria-hidden="true">
            <i class="fas fa-chevron-right"></i>
        </span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- Default box -->
<div class="card card-solid">
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('/') ?>" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari Produk..." name="keyword" value="<?= isset($keyword) ? $keyword : '' ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if (!empty($produk)) { ?>
            <div class="row">

                <?php foreach ($produk as $key => $value) { ?>
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <?php
                        echo form_open('belanja/add');
                        echo form_hidden('id', $value['id_produk']);
                        echo form_hidden('qty', 1);
                        echo form_hidden('price', $value['harga_jual']);
                        echo form_hidden('name', $value['nama_produk']);
                        echo form_hidden('gambar_produk', $value['gambar_produk']);
                        echo form_hidden('nama_satuan', $value['nama_satuan']);
                        echo form_hidden('redirect_page', str_replace('index.php/', '', current_url()));
                        ?>
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                                <h2 class="lead"><b><?= $value['nama_produk'] ?></b></h2>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">

                                        <p class="text-muted text-sm"><b>Kategori : </b><?= $value['nama_kategori'] ?></p>

                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="<?= base_url('foto/' . $value['gambar_produk']) ?>" alt="" class="img-fluid" width="150px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="text-left">
                                            <h4><span class="badge bg-primary">Rp <?= number_format($value['harga_jual'], 0) ?></span></h4>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-right">
                                            <a href="<?= base_url('store/detail_produk/' . $value['id_produk']) ?>" class="btn btn-sm btn-success">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-primary swalDefaultSuccess">
                                                <i class="fas fa-cart-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>

                <?php } ?>

                <?php if (!empty($pager)) : ?>
                    <div class="pagination justify-content-center mt-4">
                        <?= $pager->links('product_pages') ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php } else { ?>

            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                Produk tidak ditemukan.
            </div>
        <?php } ?>
    </div>
</div>

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
                title: 'Barang Berhasil Ditambahkan Ke Keranjang!'
            })
        });
    });
</script>