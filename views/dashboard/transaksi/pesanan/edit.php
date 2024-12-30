<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && $_POST['aksi'] === 'hapus') {
        // validasi CSRF token
        if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
            // Process delete
            $result = $cPesanan->hapus($_POST['id']);
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
        } else {
            $_SESSION['message'] = 'Token CSRF tidak valid';
        }
        header("Location: ?menu=transaksi&sub=pesanan");
        exit;
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cPesanan = new PesananController();
    $pesanan = $cPesanan->pesananByID($_GET['id']) ?? false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cPesanan->ubah($_GET['id'], $data);

        //jika terdapat error
        if (!array_key_exists('icon', $result) && !array_key_exists('message', $result) && !empty($result)) {
            $errors = $result; // simpan error
        } else {
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
            header("Location: ?menu=transaksi&sub=pesanan");  // Redirect after action
            exit;
        }
    } else {
        $_SESSION['message'] = 'Token CSRF tidak valid';
    }
}
?>
<div class="col-lg-12">
    <?php if ($pesanan == false) { ?>
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
            <h3 class="card-title">Ubah Pesanan <b><?= $pesanan['id'] ?></b></h3>
        </div>
        <form action="" method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label for="tgl_pesanan">Tanggal Pesanan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="date" class="form-control" id="tgl_pesanan" name="tgl_pesanan"
                            value="<?= $pesanan['tgl_pesanan'] ?>" style="pointer-events: none;">
                    </div>
                </div>
                <div class="form-group">
                    <label for="stok">Status</label>
                    <textarea type="number" class="form-control" id="status"
                        name="status"><?= $pesanan['status'] ?></textarea>
                </div>

                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>