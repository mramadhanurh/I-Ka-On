<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="<?= base_url() ?>" class="navbar-brand">
            <i class="fas fa-store text-primary"></i>
            <span class="brand-text font-weight-light"><b> <?= $web['nama_toko'] ?></b></span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= base_url() ?>" class="nav-link">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Kategori</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <?php foreach ($kategori as $key => $value) { ?>
                            <li><a href="<?= base_url('store/kategori/' . $value['id_kategori']) ?>" class="dropdown-item"><?= $value['nama_kategori'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>

                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">Contact</a>
                </li>

                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">Some action </a></li>
                        <li><a href="#" class="dropdown-item">Some other action</a></li>

                    </ul>
                </li> -->
            </ul>

        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
            <?php
            $keranjang = $cart->contents();
            $jml_item = 0;
            foreach ($keranjang as $key => $value) {
                $jml_item = $jml_item + $value['qty'];
            }
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge badge-danger navbar-badge"><?= $jml_item ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    
                        <?php if (empty($keranjang)) { ?>

                            <a href="#" class="dropdown-item">
                                <p>Keranjang Belanja Kosong</p>
                            </a>
                        <?php } else { ?>
                            <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <?php foreach ($keranjang as $key => $value) { ?>
                                <div class="media">
                                    <img src="<?= base_url('foto/' . $value['options']['gambar_produk']) ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            <?= $value['name'] ?>
                                        </h3>
                                        <p class="text-sm">Qty : <?= $value['qty'] ?></p>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                            <?php } ?>
                            <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('store/cart') ?>" class="dropdown-item dropdown-footer">View Cart</a>
                        <?php } ?>
                    
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home') ?>">
                    <i class="fas fa-user"></i>
                </a>
            </li>

        </ul>
    </div>
</nav>
<!-- /.navbar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <?= $judul ?> </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Store</a></li>
                        <li class="breadcrumb-item"><a href="#"><?= $judul ?></a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
