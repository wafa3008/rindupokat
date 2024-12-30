<?php
$cPelanggan = new PelangganController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && $_POST['aksi'] === 'hapus') {
        // validasi CSRF token
        if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
            // Process delete
            $result = $cPelanggan->hapuspelanggan($_POST['id']);
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
        } else {
            $_SESSION['message'] = 'Token CSRF tidak valid';
        }
        header("Location: ?menu=shop&sub=pelanggan");  // Redirect after action
        exit;
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><a class="btn btx-xs btn-success"
                    href="<?= getBaseUrl() . "dashboard.php?" . $dashboard->getQueryURL() . "&aksi=tambah"; ?>"><i
                        class="fas fa-plus"></i> Pelanggan</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-4">
            <table id="table" class="table table-striped mt-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Telp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $cPelanggan->semuaPelanggan();
                    foreach ($data as $pelanggan) { ?>
                        <tr>
                            <td><?= $pelanggan['id']; ?></td>
                            <td><?= $pelanggan['nama']; ?></td>
                            <td><?= $pelanggan['telp']; ?></td>
                            <td><?= $pelanggan['alamat']; ?></td>
                            <td>
                                <a href="<?= getBaseUrl() . "dashboard.php?" . $dashboard->getQueryURL() . "&aksi=edit&id=" . $pelanggan['id']; ?>"
                                    class="btn btn-sm btn-warning">Edit</a>

                                <!-- Tombol Delete -->
                                <form action="" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Apa anda yakin ingin menghapus pelanggan ini ?');">
                                    <input type="hidden" name="id" value="<?= $pelanggan['id']; ?>">
                                    <input type="hidden" name="aksi" value="hapus">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                    <!-- CSRF token -->
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('#table').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All']
        ]
    });
</script>