<?php
$cPengguna = new PenggunaController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cPengguna->tambahpengguna($data);

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
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Tambah Pengguna Baru</h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                        id="username" name="username" placeholder="Masukkan Username">
                    <?php if (isset($errors['username'])): ?>
                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                        id="password" name="password">
                    <?php if (isset($errors['password'])): ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        id="email" name="email">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
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