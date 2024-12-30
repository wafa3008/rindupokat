<?php
$cPengguna = new PenggunaController();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cPengguna = new PenggunaController();
    $pengguna = $cPengguna->penggunaById($_GET['id']) ?? false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cPengguna->ubahpengguna($_GET['id'], $data);

        //jika terdapat error
        if (!array_key_exists('icon', $result) && !array_key_exists('message', $result) && !empty($result)) {
            $errors = $result; // simpan error
        } else {
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
            header("Location: ?menu=pengaturan&sub=pengguna");  // Redirect after action
            exit;
        }
    } else {
        $_SESSION['message'] = 'Token CSRF tidak valid';
    }
}
?>
<div class="col-lg-12">
    <?php if ($pengguna == false) { ?>
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">Oops Terjadi Kesalahan!</h4>
            <p>Gagal mengambil data, Pengguna tidak ditemukan</p>
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
            <h3 class="card-title">Ubah Pengguna <b><?= $pengguna['username'] ?></b></h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?= $pengguna['username'] ?>" placeholder="Masukkan Username">
                    <?php if (isset($errors['username'])): ?>
                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan Password">
                    <?php if (isset($errors['password'])): ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= $pengguna['email'] ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
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