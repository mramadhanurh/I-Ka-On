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
            <?php
            if (session()->getFlashdata('success')) {
                echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('success');
                echo '</h5></div>';
            }
            ?>
            <?= session()->getFlashdata('error') ? '<div class="alert alert-danger">'.session()->getFlashdata('error').'</div>' : '' ?>

            <form action="<?= base_url('Home/SettingUserSave') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="nama_user">Nama User</label>
                    <input type="text" name="nama_user" class="form-control" value="<?= esc($user['nama_user']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control">
                    <small id="password" class="form-text text-danger">*Kosongi jika tidak ingin mengubah password.</small>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
