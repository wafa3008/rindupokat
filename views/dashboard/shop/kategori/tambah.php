<?php
$cKategori = new KategoriController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cKategori->tambahkategori($data);

        //jika terdapat error
        if (!array_key_exists('icon', $result) && !array_key_exists('message', $result) && !empty($result)) {
            $errors = $result; // simpan error
        } else {
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
            header("Location: ?menu=shop&sub=kategori");  // Redirect after action
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
            <h3 class="card-title">Tambah Kategori Baru</h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama"
                        name="nama" placeholder="Masukkan Nama Kategori">
                    <?php if (isset($errors['nama'])): ?>
                        <div class="invalid-feedback"><?= $errors['nama'] ?></div>
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
                    <label for="deskripsi">Size</label>
                    <textarea class="form-control <?= isset($errors['size']) ? 'is-invalid' : '' ?>" id="size"
                        name="size" rows="3"></textarea>
                    <?php if (isset($errors['size'])): ?>
                        <div class="invalid-feedback"><?= $errors['size'] ?></div>
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