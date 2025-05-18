<div class="col-md-12">
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title">Warna Produk: <?= $produk['nama_produk'] ?></h3>
        </div>

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

            <form method="post" action="<?= base_url('produk/insertWarna') ?>">
                <div class="row">
                    <input type="hidden" name="id_produk" class="form-control" value="<?= $produk['id_produk'] ?>">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Warna</label>
                            <select name="id_warna" class="form-control">
                                <option value="">--Pilih Warna--</option>
                                <?php foreach ($warna as $w) : ?>
                                    <option value="<?= $w['id_warna'] ?>"><?= $w['nama_warna'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                    <a href="<?= base_url('Produk') ?>" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </form>

            <hr>

            <h5>Variasi Warna Saat Ini:</h5>
            <ul>
                <?php foreach ($variasi as $v) : ?>
                    <li><?= $v['nama_warna'] ?>
                        <a href="<?= base_url('produk/deleteWarna/' . $v['id_produk_warna']) ?>">[hapus]</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>