<?php
$cProduk = new ProdukController();
$cKategori = new KategoriController();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cProduk = new ProdukController();
    $produk = $cProduk->produkById($_GET['id']) ?? false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cProduk->ubahproduk($_GET['id'], $data);

        //jika terdapat error
        if (!array_key_exists('icon', $result) && !array_key_exists('message', $result) && !empty($result)) {
            $errors = $result; // simpan error
        } else {
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
            header("Location: ?menu=shop&sub=produk");  // Redirect after action
            exit;
        }
    } else {
        $_SESSION['message'] = 'Token CSRF tidak valid';
    }
}
?>
<div class="col-lg-12">
    <?php if ($produk == false) { ?>
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">Oops Terjadi Kesalahan!</h4>
            <p>Gagal mengambil data, Produk tidak ditemukan</p>
            <hr>
            <h3><a class="btn btx-xs btn-primary"
                    href="<?= getBaseUrl() . "dashboard?menu=" . $dashboard->getMenuName() ?>"><i class="fas fa-undo"></i>
                    Kembali</a>
            </h3>
        </div>
        <?php exit;
    } ?>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Ubah Produk <b><?= $produk['nama'] ?></b></h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $produk['nama'] ?>"
                        placeholder="Masukkan Nama Produk">
                    <?php if (isset($errors['nama'])): ?>
                        <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="number" class="form-control" id="harga" name="harga"
                            value="<?= $produk['harga'] ?>">
                        <?php if (isset($errors['harga'])): ?>
                            <div class="invalid-feedback"><?= $errors['harga'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= $produk['stock'] ?>">
                    <?php if (isset($errors['stock'])): ?>
                        <div class="invalid-feedback"><?= $errors['stock'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="deskripsi">deskripsi</label>
                    <textarea class="form-control <?= isset($errors['deskripsi']) ? 'is-invalid' : '' ?>" id="deskripsi"
                        name="deskripsi" rows="3"><?= $produk['deskripsi'] ?></textarea>
                    <?php if (isset($errors['deskripsi'])): ?>
                        <div class="invalid-feedback"><?= $errors['deskripsi'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select class="custom-select form-control-border border-width-2" id="kategori_id"
                        name="kategori_id">
                        <?php foreach ($cKategori->semuaKategori() as $kategori) { ?>
                            <option value="<?= $kategori['id'] ?>" <?= $kategori['id'] == $produk['kategori_id'] ? 'selected' : '' ?>><?= $kategori['nama'] ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($errors['kategori_id'])): ?>
                        <div class="invalid-feedback"><?= $errors['kategori_id'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="nama">Upload Foto</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    <?php if (isset($errors['photo'])): ?>
                        <div class="invalid-feedback"><?= $errors['photo'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Submit</button>
            </div>
        </form>
    </div>
</div>