<?php
$cPelanggan = new PelangganController();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cPelanggan = new PelangganController();
    $pelanggan = $cPelanggan->pelangganById($_GET['id']) ?? false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cPelanggan->ubahpelanggan($_GET['id'], $data);

        //jika terdapat error
        if (!array_key_exists('icon', $result) && !array_key_exists('message', $result) && !empty($result)) {
            $errors = $result; // simpan error
        } else {
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
            header("Location: ?menu=shop&sub=pelanggan");  // Redirect after action
            exit;
        }
    } else {
        $_SESSION['message'] = 'Token CSRF tidak valid';
    }
}
?>
<div class="col-lg-12">
    <?php if ($pelanggan == false) { ?>
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">Oops Terjadi Kesalahan!</h4>
            <p>Gagal mengambil data, Pelanggan tidak ditemukan</p>
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
            <h3 class="card-title">Ubah Pelanggan <b><?= $pelanggan['nama'] ?></b></h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $pelanggan['nama'] ?>"
                        placeholder="Masukkan Nama Pelanggan">
                    <?php if (isset($errors['nama'])): ?>
                        <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="telp">Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text">Hp.</span>
                        <input type="text" class="form-control" id="telp" name="telp" value="<?= $pelanggan['telp'] ?>">
                        <?php if (isset($errors['telp'])): ?>
                            <div class="invalid-feedback"><?= $errors['telp'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat"
                        name="alamat" rows="3"><?= $pelanggan['alamat'] ?></textarea>
                    <?php if (isset($errors['deskripsi'])): ?>
                        <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
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