<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="<?= getBaseUrl() . "dashboard.php" ?>" class="brand-link">
        <img src="<?= $logo ?>" alt="<?= $app_name ?> Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light"><?= strtoupper($app_name) ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= getBaseUrl() . "assets/images/produk/user.jpg" ?>" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Welcome, <b><?= $_SESSION['user']['username'] ?></b></a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= getBaseUrl() . "dashboard.php" ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p class="font-weight-bold">
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-shop"></i>
                        <p class="font-weight-bold">
                            Manajemen Toko
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach (DashboardController::VALID_MENU['shop'] as $shopMenu) { ?>
                            <li class="nav-item">
                                <a href="?menu=shop&sub=<?= $shopMenu ?>"
                                    class="nav-link <?= ($dashboard->getSubName() === $shopMenu) ? 'active' : ''; ?>">
                                    <i class="fas fa-circle-dot nav-icon"></i>
                                    <p><?php echo ucfirst($shopMenu); ?></p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p class="font-weight-bold">
                            Transaksi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach (DashboardController::VALID_MENU['transaksi'] as $transaksiMenu) { ?>
                            <li class="nav-item">
                                <a href="?menu=transaksi&sub=<?= $transaksiMenu ?>"
                                    class="nav-link <?= ($dashboard->getSubName() === $transaksiMenu) ? 'active' : ''; ?>">
                                    <i class="fas fa-circle-dot nav-icon"></i>
                                    <p><?php echo ucfirst($transaksiMenu); ?></p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-copy"></i>
                        <p class="font-weight-bold">
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach (DashboardController::VALID_MENU['laporan'] as $reportMenu) { ?>
                            <li class="nav-item">
                                <a href="?menu=laporan&sub=<?= $reportMenu ?>&aksi=cetak"
                                    class="nav-link <?= ($dashboard->getSubName() === $reportMenu) ? 'active' : ''; ?>">
                                    <i class="fas fa-circle-dot nav-icon"></i>
                                    <p><?php echo ucfirst($reportMenu); ?></p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-gear"></i>
                        <p class="font-weight-bold">
                            Pengaturan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach (DashboardController::VALID_MENU['pengaturan'] as $settingMenu) { ?>
                            <li class="nav-item">
                                <a href="?menu=pengaturan&sub=<?= $settingMenu ?>"
                                    class="nav-link <?= ($dashboard->getSubName() === $settingMenu) ? 'active' : ''; ?>">
                                    <i class="fas fa-circle-dot nav-icon"></i>
                                    <p><?php echo ucfirst($settingMenu); ?></p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>