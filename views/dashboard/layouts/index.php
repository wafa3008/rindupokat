<div class="container">
    <!-- Produk Terbaru ditambahkan -->
    <h3 class="fw-bold"><i class="bi bi-clock-history"></i> Produk Terbaru</h3>
    <p class="lead"><small>Dapatkan segera produk terbaru dari kami, yang mungkin menarik bagi anda</small></p>
    <div class="container mt-3">
        <!-- Tampilan saat tampilan desktop / large device -->
        <div id="newProductCarouselDesktop" class="carousel slide mb-4 d-none d-lg-block" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $productChunks = array_chunk($cHome->produkTerkini(), 3);
                $isActive = true;
                foreach ($productChunks as $chunk) {
                    echo '<div class="carousel-item' . ($isActive ? ' active' : '') . '">';
                    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
                    foreach ($chunk as $product) {
                        echo '<div class="col">';
                        echo '  <div class="card mb-3" style="max-width: 540px; max-height: 150px" data-bs-toggle="modal" data-bs-target="#produkModal" 
                            data-id="' . htmlspecialchars($product['id']) . '"
                            data-name="' . htmlspecialchars($product['nama']) . '"
                            data-description="' . htmlspecialchars($product['deskripsi']) . '"
                            data-photo="' . $product['photo'] . '"
                            data-stock="' . htmlspecialchars($product['stock']) . '"
                            data-price="' . htmlspecialchars($product['harga']) . '"
                            data-category="' . htmlspecialchars($product['nama_kategori']) . '">';
                        echo '    <div class="row g-0">';
                        echo '      <div class="col-md-4 align-items-center">';
                        echo '        <img src="' . $product['photo'] . '" class="img-fluid h-100 w-auto rounded-start" style="max-height: 150px" alt="' . $product['nama'] . '">';
                        echo '      </div>';
                        echo '      <div class="col-md-8">';
                        echo '        <div class="card-body">';
                        echo '          <h5 class="card-title fw-bold fs-4 fs-md-6 mb-0">' . $product['nama'] . '</h5>';
                        echo '          <span class="badge text-bg-primary">' . $product['nama_kategori'] . '</span>';
                        echo '          <small class="text-body-secondary d-none d-lg-block">' . $product['deskripsi'] . '</small>';
                        echo '          <div class="d-flex justify-content-between align-items-center">';
                        echo '              <small class="text-body-secondary text-dark fs-6 fw-semibold">Stock: ' . $product['stock'] . '</small>';
                        echo '              <p class="card-text mb-1 fw-bold fs-5">Rp. ' . number_format($product['harga'], 0, ',', '.') . '</p>';
                        echo '          </div>';
                        echo '        </div>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                    $isActive = false;
                }
                ?>
            </div>
        </div>

        <!-- Tampilan saat tampilan mobile / small device -->
        <div id="newProductCarouselMobile" class="carousel slide mb-4 d-block d-lg-none" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $productChunks = array_chunk($cHome->produkTerkini(), 1);
                $isActive = true;
                foreach ($productChunks as $chunk) {
                    echo '<div class="carousel-item' . ($isActive ? ' active' : '') . '">';
                    echo '<div class="row row-cols-1 g-1">';
                    foreach ($chunk as $product) {
                        echo '<div class="col">';
                        echo '  <div class="card mb-3 w-auto" style="max-height: 150px" data-bs-toggle="modal" data-bs-target="#produkModal" 
                            data-id="' . htmlspecialchars($product['id']) . '"
                            data-name="' . htmlspecialchars($product['nama']) . '"
                            data-description="' . htmlspecialchars($product['deskripsi']) . '"
                            data-photo="' . $product['photo'] . '"
                            data-stock="' . htmlspecialchars($product['stock']) . '"
                            data-price="' . htmlspecialchars($product['harga']) . '"
                            data-category="' . htmlspecialchars($product['nama_kategori']) . '">';
                        echo '    <div class="row g-0">';
                        echo '      <div class="col-4 align-items-center">';
                        echo '        <img src="' . $product['photo'] . '" class="img-fluid h-100 w-auto rounded-start" style="max-height: 150px" alt="' . $product['nama'] . '">';
                        echo '      </div>';
                        echo '      <div class="col-8">';
                        echo '        <div class="card-body">';
                        echo '          <h5 class="card-title fw-bold fs-5">' . $product['nama'] . '</h5>';
                        echo '          <span class="badge text-bg-primary">' . $product['nama_kategori'] . '</span>';
                        echo '          <small class="text-body-secondary lead">' . $product['deskripsi'] . '</small>';
                        echo '          <div class="d-flex justify-content-between align-items-center">';
                        echo '              <small class="text-body-secondary text-dark fs-6 fw-semibold">Stock: ' . $product['stock'] . '</small>';
                        echo '              <p class="card-text mb-1 fw-bold fs-5">Rp. ' . number_format($product['harga'], 0, ',', '.') . '</p>';
                        echo '          </div>';
                        echo '        </div>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                    $isActive = false;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <h3 class="fw-bold text-success"><i class="bi bi-heart-fill text-danger"></i> Paling Laris</h3>
    <p class="lead"><small>Pilihan terbaik dari pelanggan kami tercinta</small></p>

    <div class="container mt-3 bg-success bg-opacity-50 py-2 px-2 py-lg-4 px-lg-4 rounded">
        <!-- Tampilan saat tampilan desktop / large device -->
        <div id="featuredCarouselDesktop" class="carousel slide d-none d-lg-block carousel-fade"
            data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $productChunks = array_chunk($cHome->produkTerkini(), 3);
                $isActive = true;
                foreach ($productChunks as $chunk) {
                    echo '<div class="carousel-item' . ($isActive ? ' active' : '') . '" data-bs-interval="3000">';
                    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
                    foreach ($chunk as $product) {
                        echo '  <div class="col">';
                        echo '    <div class="card" style="max-height: 160px" data-bs-toggle="modal" data-bs-target="#produkModal" 
                            data-id="' . htmlspecialchars($product['id']) . '"
                            data-name="' . htmlspecialchars($product['nama']) . '"
                            data-description="' . htmlspecialchars($product['deskripsi']) . '"
                            data-photo="' . $product['photo'] . '"
                            data-stock="' . htmlspecialchars($product['stock']) . '"
                            data-price="' . htmlspecialchars($product['harga']) . '"
                            data-category="' . htmlspecialchars($product['nama_kategori']) . '">';
                        echo '      <img src="' . $product['photo'] . '" class="card-img object-fit-cover opacity-75" style="max-height: 160px;" alt="' . $product['nama'] . '">';
                        echo '      <div class="card-img-overlay bg-primary bg-opacity-25 d-flex flex-column justify-content-end">';
                        echo '          <h5 class="card-title fw-bold text-dark fs-4">' . $product['nama'] . '</h5>';
                        echo '          <span class="position-absolute top-0 end-0 bg-danger px-1 rounded-end-2 rounded-bottom-0 fw-semibold">' . $product['nama_kategori'] . '</span>';
                        echo '          <p class="text-dark">' . $product['deskripsi'] . '</p>';
                        echo '          <div class="d-flex justify-content-between align-items-center">';
                        echo '              <small class="text-body-secondary text-dark fs-5 fw-semibold">Stock: ' . $product['stock'] . '</small>';
                        echo '              <p class="card-text mb-1 fw-bold fs-4">Rp. ' . number_format($product['harga'], 0, ',', '.') . '</p>';
                        echo '          </div>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                    }
                    echo '</div>';
                    echo '</div>';
                    $isActive = false;
                }
                ?>
            </div>
        </div>

        <!-- Tampilan saat tampilan mobile / small device -->
        <div id="featuredCarouselMobile" class="carousel slide d-block d-lg-none carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $productChunks = array_chunk($cHome->produkTerkini(), 1);
                $isActive = true;
                foreach ($productChunks as $chunk) {
                    echo '<div class="carousel-item' . ($isActive ? ' active' : '') . '" data-bs-interval="3000">';
                    echo '<div class="row row-cols-1 g-1">';
                    foreach ($chunk as $product) {
                        echo '  <div class="col">';
                        echo '    <div class="card" style="max-height: 160px" data-bs-toggle="modal" data-bs-target="#produkModal" 
                            data-id="' . htmlspecialchars($product['id']) . '"
                            data-name="' . htmlspecialchars($product['nama']) . '"
                            data-description="' . htmlspecialchars($product['deskripsi']) . '"
                            data-photo="' . $product['photo'] . '"
                            data-stock="' . htmlspecialchars($product['stock']) . '"
                            data-price="' . htmlspecialchars($product['harga']) . '"
                            data-category="' . htmlspecialchars($product['nama_kategori']) . '">';
                        echo '      <img src="' . $product['photo'] . '" class="card-img object-fit-cover opacity-75" style="max-height: 160px;" alt="' . $product['nama'] . '">';
                        echo '      <div class="card-img-overlay bg-primary bg-opacity-25 d-flex flex-column justify-content-end">';
                        echo '          <h5 class="card-title fw-bold text-dark">' . $product['nama'] . '</h5>';
                        echo '          <span class="position-absolute top-0 end-0 bg-danger px-1 rounded-end-2 rounded-bottom-0 fw-semibold">' . $product['nama_kategori'] . '</span>';
                        echo '          <p class="text-dark">' . $product['deskripsi'] . '</p>';
                        echo '          <div class="d-flex justify-content-between align-items-center">';
                        echo '              <small class="text-body-secondary text-dark">Stock: ' . $product['stock'] . '</small>';
                        echo '              <p class="card-text mb-1 text-dark fw-bold fs-4">Rp. ' . number_format($product['harga'], 0, ',', '.') . '</p>';
                        echo '          </div>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                    }
                    echo '</div>';
                    echo '</div>';
                    $isActive = false;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Produk Berdasarkan Kategori -->
    <hr class="mt-5">
    <h3 class="text-center fs-1"><i class="bi bi-grid-fill text-success"></i></h3>
    <figure class="text-center">
        <blockquote class="blockquote">
            <h3 class="text-uppercase fw-bold fs-3">Produk Kami</h3>
        </blockquote>
        <figcaption class="blockquote-footer">
            Temukan produk kami lainnya berdasarkan <cite title="Source Title">kategori</cite> yang anda inginkan
        </figcaption>
    </figure>
    <ul class="nav nav-pills my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link <?= (!isset($_GET['kategori']) || $_GET['kategori'] === 'semua') ? 'active' : '' ?>"
                aria-current="page" href="?kategori=semua">Semua</a>
        </li>
        <?php foreach ($cHome->kategoris() as $kategori) { ?>
            <li class="nav-item">
                <a class="nav-link <?= (isset($_GET['kategori']) && $_GET['kategori'] === $kategori['nama']) ? 'active' : '' ?>"
                    href="?kategori=<?= $kategori['nama'] ?>" aria-current="page"><?= $kategori['nama'] ?></a>
            </li>
        <?php } ?>
    </ul>
    <div class="overflow-y-scroll overflow-x-hidden bg-primary bg-opacity-25 py-4 px-4 rounded"
        style="max-height: 600px;">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php
            if (isset($_GET['kategori'])) {
                $produk = $cHome->produkKategori($_GET['kategori']);
            } else {
                $produk = $cHome->produkKategori('');
            }

            if (empty($produk)) { ?>
                <div class="col-12 text-center">
                    <div class="alert alert-warning" role="alert">
                        Produk belum tersedia
                    </div>
                </div>
            <?php } else
                foreach ($produk as $p) { ?>
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <div class="card-body" data-bs-toggle="modal" data-bs-target="#produkModal"
                                data-id="<?= htmlspecialchars($p['id']); ?>" data-name="<?= htmlspecialchars($p['nama']); ?>"
                                data-description="<?= htmlspecialchars($p['deskripsi']); ?>" data-photo="<?= $p['photo']; ?>"
                                data-stock="<?= htmlspecialchars($p['stock']); ?>"
                                data-price="<?= htmlspecialchars($p['harga']); ?>"
                                data-category="<?= htmlspecialchars($p['nama_kategori']); ?>">
                                <img src="<?= $p['photo']; ?>" class="rounded card-img-top" style="height: 150px"
                                    alt="<?= $p['nama']; ?>">
                                <span
                                    class="position-absolute top-0 end-0 bg-danger px-1 rounded-end-2 rounded-bottom-0 fw-semibold"><?= $p['nama_kategori'] ?></span>
                                <p class="card-text fw-bold fs-4"><?= $p['nama']; ?></p>
                                <p class="card-text lead fs-6"><?= $p['deskripsi']; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-body-secondary text-dark">Stock: <?= $p['stock']; ?></small>
                                    <p class="card-text mb-1 text-success fw-bold fs-4 text-end">Rp.
                                        <?= number_format($p['harga'], 0, ',', '.'); ?>
                                    </p>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['user'])): ?>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <form action="" method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('Tambahkan item ini ke keranjang ?');">
                                            <input type="hidden" name="id_produk" value="<?= $p['id']; ?>">
                                            <input type="hidden" value="addKeranjang" name="aksi">
                                            <div class="input-group mb-2 justify-content-center">
                                                <input type="number" class="form-control" name="jumlah" id="jumlah" min="0"
                                                    value="0" required aria-describedby="button-addon2">
                                                <button class="btn btn-sm btn-success" type="submit" id="button-addon2">
                                                    <i class="bi bi-cart-plus-fill me-1"></i>Keranjang
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                <?php } ?>
        </div>
    </div>
</div>