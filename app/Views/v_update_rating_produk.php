<div class="col-md-12">
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>

            <div class="card-tools">
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <form action="<?= base_url('Pesananuser/saveUpdateRating/' . $transaksi['id_transaksi']); ?>" method="post">
                <?= csrf_field(); ?>

                <h4>Update Rating Produk</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rinciTransaksi as $rinci) : ?>
                            <tr>
                                <td class="text-center"><?= $rinci['id_produk']; ?></td>
                                <td><?= $rinci['nama_produk']; ?></td>
                                <td>
                                    <input type="hidden" name="id_produk[]" value="<?= $rinci['id_produk']; ?>">
                                    <div class="rating">
                                        <?php for ($i = 5; $i >= 1; $i--) : ?>
                                            <input type="radio" name="rating_<?= $rinci['id_produk']; ?>" value="<?= $i; ?>" id="star<?= $i; ?>_<?= $rinci['id_produk']; ?>">
                                            <label for="star<?= $i; ?>_<?= $rinci['id_produk']; ?>"><i class="far fa-star"></i></label>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<script>
    document.querySelectorAll('.rating input').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Update icon bintang
            let name = this.name;
            let value = this.value;
            let labels = document.querySelectorAll('input[name="'+name+'"] ~ label');
            labels.forEach(function(label) {
                label.querySelector('i').classList.remove('fas');
                label.querySelector('i').classList.add('far');
            });
            for (let i = 1; i <= value; i++) {
                let label = document.querySelector('label[for="star'+i+'_'+this.id.split("_")[1]+'"] i');
                if (label) {
                    label.classList.remove('far');
                    label.classList.add('fas');
                }
            }
        });
    });
</script>