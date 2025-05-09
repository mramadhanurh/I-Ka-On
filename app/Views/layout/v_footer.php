</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer" style="margin-top: 100px;">
    <div class="row">
        <!-- Card 1: Nama Toko dan Slogan -->
        <div class="col-md-4">
            <div class="card-body">
                <h3><?= $web['nama_toko'] ?></h3>
                <p class="card-text"><b><?= $web['slogan'] ?></b><br><?= $web['deskripsi'] ?></p>

            </div>
        </div>

        <!-- Card 2: Alamat -->
        <div class="col-md-4">
            <div class="card-body">
                <h5 class="card-title">Alamat</h5>
                <p class="card-text"><?= $web['alamat'] ?></p>
            </div>
        </div>

        <!-- Card 3: No Telpon -->
        <div class="col-md-4">
            <div class="card-body">
                <h5 class="card-title">Telfon</h5>
                <p class="card-text"><?= $web['no_telpon'] ?></p>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="text-center mt-4">
        <strong>Copyright &copy; 2024 <a href="#"><?= $web['nama_toko'] ?></a>.</strong> All rights reserved.
    </div>
</footer>
</div>
<!-- ./wrapper -->

</body>

</html>