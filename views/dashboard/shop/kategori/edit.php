<?php
$cKategori = new KategoriController();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cKategori = new KategoriController();
    $kategori = $cKategori->kategoriById($_GET['id']) ?? false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cKategori->ubahkategori($_GET['id'], $data);

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
    <?php if ($kategori == false) { ?>
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">Oops Terjadi Kesalahan!</h4>
            <p>Gagal mengambil data, Kategori tidak ditemukan</p>
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
            <h3 class="card-title">Ubah Kategori <b><?= $kategori['nama'] ?></b></h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $kategori['nama'] ?>"
                        placeholder="Masukkan Nama Kategori">
                    <?php if (isset($errors['nama'])): ?>
                        <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="deskripsi">deskripsi</label>
                    <textarea class="form-control <?= isset($errors['deskripsi']) ? 'is-invalid' : '' ?>" id="deskripsi"
                        name="deskripsi" rows="3"><?= $kategori['deskripsi'] ?></textarea>
                    <?php if (isset($errors['deskripsi'])): ?>
                        <div class="invalid-feedback"><?= $errors['deskripsi'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="deskripsi">size</label>
                    <textarea class="form-control <?= isset($errors['size']) ? 'is-invalid' : '' ?>" id="size"
                        name="size" rows="4"><?= $kategori['size'] ?></textarea>
                    <?php if (isset($errors['size'])): ?>
                        <div class="invalid-feedback"><?= $errors['size'] ?></div>
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