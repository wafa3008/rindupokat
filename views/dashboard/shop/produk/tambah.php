<?php
$cProduk = new ProdukController();
$cKategori = new KategoriController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cProduk->tambahproduk($data);

        unset($_POST);
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
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Tambah Produk Baru</h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama"
                        name="nama" placeholder="Masukkan Nama Produk">
                    <?php if (isset($errors['nama'])): ?>
                        <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="number" class="form-control <?= isset($errors['harga']) ? 'is-invalid' : '' ?>"
                            id="harga" name="harga">
                    </div>
                    <?php if (isset($errors['harga'])): ?>
                        <div class="invalid-feedback"><?= $errors['harga'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>"
                        id="stock" name="stock">
                    <?php if (isset($errors['stock'])): ?>
                        <div class="invalid-feedback"><?= $errors['stock'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control <?= isset($errors['deskripsi']) ? 'is-invalid' : '' ?>" id="deskripsi"
                        name="deskripsi" rows="3"></textarea>
                    <?php if (isset($errors['deskripsi'])): ?>
                        <div class="invalid-feedback"><?= $errors['deskripsi'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select class="custom-select form-control-border border-width-2" id="kategori_id"
                        name="kategori_id">
                        <?php foreach ($cKategori->semuaKategori() as $kategori) { ?>
                            <option value="<?= $kategori['id'] ?>"><?= $kategori['nama'] ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset($errors['kategori_id'])): ?>
                        <div class="invalid-feedback"><?= $errors['kategori_id'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="nama">Upload Foto</label>
                    <input type="file" class="form-control <?= isset($errors['photo']) ? 'is-invalid' : '' ?>"
                        id="photo" name="photo" accept="image/*">
                    <?php if (isset($errors['photo'])): ?>
                        <div class="invalid-feedback"><?= $errors['photo'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>