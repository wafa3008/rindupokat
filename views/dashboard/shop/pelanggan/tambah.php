<?php
$cPelanggan = new PelangganController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cPelanggan->tambahpelanggan($data);

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
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Tambah Pelanggan Baru</h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Pelanggan</label>
                    <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama"
                        name="nama" placeholder="Masukkan Nama Pelanggan">
                    <?php if (isset($errors['nama'])): ?>
                        <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="telp">Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text">Hp.</span>
                        <input type="text" class="form-control <?= isset($errors['telp']) ? 'is-invalid' : '' ?>"
                            id="telp" name="telp">
                    </div>
                    <?php if (isset($errors['telp'])): ?>
                        <div class="invalid-feedback"><?= $errors['telp'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat"
                        name="alamat" rows="3"></textarea>
                    <?php if (isset($errors['alamat'])): ?>
                        <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
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