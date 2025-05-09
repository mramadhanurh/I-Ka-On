<h4>Tambah Warna Produk: <?= $produk['nama_produk'] ?></h4>
<form method="post" action="<?= base_url('produk/insertWarna') ?>">
    <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
    <select name="id_warna">
        <?php foreach ($warna as $w) : ?>
            <option value="<?= $w['id_warna'] ?>"><?= $w['nama_warna'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Tambah</button>
</form>

<hr>
<h5>Variasi Warna Saat Ini:</h5>
<ul>
    <?php foreach ($variasi as $v) : ?>
        <li><?= $v['nama_warna'] ?> - <?= $v['stok'] ?> pcs
            <a href="<?= base_url('produk/deleteWarna/' . $v['id_produk_warna']) ?>">[hapus]</a>
        </li>
    <?php endforeach; ?>
</ul>