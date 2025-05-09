<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Gambar Produk: <?= $produk['nama_produk'] ?></h3>
        </div>

        <div class="card-body">
            <?php
            if (session()->getFlashdata('success')) {
                echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('success');
                echo '</h5></div>';
            }
            ?>

            <form action="<?= base_url('produk/uploadGambar') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="id_produk" class="form-control" value="<?= $produk['id_produk'] ?>">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="gambar[]" class="form-control" multiple required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                    <a href="<?= base_url('Produk') ?>" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </form>

            <hr>

            <div class="row">
                <?php foreach ($gambar as $img) : ?>
                    <div class="col-md-3 text-center">
                        <img src="<?= base_url('foto/' . $img['nama_file']) ?>" class="img-fluid" style="max-height: 150px;">
                        <form action="<?= base_url('produk/hapusGambar/' . $img['id']) ?>" method="post" onsubmit="return confirm('Hapus gambar ini?')">
                            <button type="submit" class="btn btn-danger btn-xs btn-block"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>