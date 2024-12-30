<header>
    <!-- tombol theme dark /light bootstrap icon-->
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z">
            </path>
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"></path>
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z">
            </path>
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z">
            </path>
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
            </path>
        </symbol>
    </svg>

    <div class="px-3 py-2 text-bg-dark border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="<?= getBaseUrl() ?>"
                    class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none text-uppercase fs-4">
                    <img src="<?= $logo ?>" alt="<?= $app_name ?> Logo" class="brand-image me-2" style="opacity: .8"
                        width="40" height="32"> <?= $app_name ?>
                </a>

                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <li>
                        <a href="<?= getBaseUrl() ?>" class="nav-link text-white">
                            <i class="bi bi-house-fill d-block mx-auto mb-1 text-center"></i>
                            Home
                        </a>
                    </li>
                    <?php if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id_pelanggan'])): ?>
                        <li>
                            <a href="?menu=keranjang" class="nav-link text-white">
                                <i class="bi bi-bag-heart-fill d-block mx-auto mb-1 text-center"></i>
                                Keranjang
                            </a>
                        </li>
                        <li>
                            <a href="?menu=pesanan" class="nav-link text-white">
                                <i class="bi bi-cart-fill d-block mx-auto mb-1 text-center"></i>
                                Pesanan
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="?menu=produk" class="nav-link text-white">
                            <i class="bi bi-grid-fill d-block mx-auto mb-1 text-center"></i>
                            Products
                        </a>
                    </li>
                    <?php if (!empty($_SESSION['user']) && empty($_SESSION['user']['id_pelanggan'])): ?>
                        <li>
                            <a href="dashboard.php" class="nav-link bg-warning text-black">
                                <i class="bi bi-speedometer d-block mx-auto mb-1 text-center"></i>
                                Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form action="?menu=produk" method="GET" class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                <input type="hidden" value="produk" name="menu">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search" name="search">
            </form>

            <div class="text-end">
                <?php if (empty($_SESSION['user'])): ?>
                    <a href="login.php" class="btn btn-light text-dark me-2">Login</a>
                    <a href="register.php" class="btn btn-primary me-2">Sign-up</a>
                <?php else: ?>
                    <span class="me-2">Selamat Datang,
                        <b><?= htmlspecialchars($_SESSION['user']['username'] ?? 'User') ?></b></span>
                    <form action="" method="POST" style="display:inline-block;"
                        onsubmit="return confirm('Apa anda yakin ingin keluar dari akun ini ?');">
                        <input type="hidden" value="logout" name="aksi">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-person-fill-lock me-1"></i>Logout
                        </button>
                    </form>
                <?php endif; ?>
                <button class="btn btn-bd-light dropdown-toggle align-items-center" id="bd-theme" type="button"
                    aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (light)">
                    <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center active"
                            data-bs-theme-value="light" aria-pressed="true">
                            <svg class="bi me-2 opacity-50" width="1em" height="1em">
                                <use href="#sun-fill"></use>
                            </svg>
                            Light
                            <svg class="bi ms-auto d-none" width="1em" height="1em">
                                <use href="#check2"></use>
                            </svg>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                            aria-pressed="false">
                            <svg class="bi me-2 opacity-50" width="1em" height="1em">
                                <use href="#moon-stars-fill"></use>
                            </svg>
                            Dark
                            <svg class="bi ms-auto d-none" width="1em" height="1em">
                                <use href="#check2"></use>
                            </svg>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"
                            aria-pressed="false">
                            <svg class="bi me-2 opacity-50" width="1em" height="1em">
                                <use href="#circle-half"></use>
                            </svg>
                            Auto
                            <svg class="bi ms-auto d-none" width="1em" height="1em">
                                <use href="#check2"></use>
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>