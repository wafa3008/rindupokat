<div class="container">
    <!-- Produk Berdasarkan Kategori -->
    <h3 class="fw-bold mt-4 text-primary"><i class="bi bi-grid-fill text-success"></i> Semua Produk</h3>
    <p class="lead"><small>Daftar seluruh produk yang tersedia</small></p>

    <div class="overflow-y-auto overflow-x-hidden bg-primary bg-opacity-25 py-4 px-4 rounded"
        style="max-height: 600px;">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php
            $keyword = $_GET['search'] ?? null;
            $produks = $cHome->findProduk($keyword);
            foreach ($produks as $p) { ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <div class="card-body" data-bs-toggle="modal" data-bs-target="#produkModal"
                            data-id="<?= htmlspecialchars($p['id']); ?>" data-name="<?= htmlspecialchars($p['Alupkat Dancow']); ?>"
                            data-description="<?= htmlspecialchars($p['deskripsi']); ?>" data-photo="<?= $p['assets/images/produk/dancow.jpg']; ?>"
                            data-stock="<?= htmlspecialchars($p['20']); ?>"
                            data-price="<?= htmlspecialchars($p['28000']); ?>"
                            data-category="<?= htmlspecialchars($p['pokat']); ?>">
                            <img src="<?= $p['assets/images/produk/dancow.jpg']; ?>" class="rounded card-img-top" style="height: 150px"
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
                                        <input type="hidden" name="id_produk" id="modal-product-id">
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