<?php
$cPengguna = new PenggunaController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && $_POST['aksi'] === 'hapus') {
        // validasi CSRF token
        if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
            // Process delete
            $result = $cPengguna->hapuspengguna($_POST['id']);
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
        } else {
            $_SESSION['message'] = 'Token CSRF tidak valid';
        }
        header("Location: ?menu=pengaturan&sub=pengguna");  // Redirect after action
        exit;
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><a class="btn btx-xs btn-success"
                    href="<?= getBaseUrl() . "dashboard.php?" . $dashboard->getQueryURL() . "&aksi=tambah"; ?>"><i
                        class="fas fa-plus"></i> Pengguna</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-4">
            <table id="table" class="table table-striped mt-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $cPengguna->semuaPengguna();
                    foreach ($data as $pengguna) { ?>
                        <tr>
                            <td><?= $pengguna['id']; ?></td>
                            <td><?= $pengguna['username']; ?></td>
                            <td><?= $pengguna['email']; ?></td>
                            <td><?= $pengguna['password']; ?></td>
                            <td><span
                                    class="badge badge-<?= $pengguna['id_pelanggan'] ? 'warning' : 'success'; ?>"><?= $pengguna['id_pelanggan'] ? 'Pelanggan' : 'Admin'; ?></span>
                            </td>
                            <td>
                                <a href="<?= getBaseUrl() . "dashboard.php?" . $dashboard->getQueryURL() . "&aksi=edit&id=" . $pengguna['id']; ?>"
                                    class="btn btn-sm btn-warning">Edit</a>

                                <!-- Tombol Delete -->
                                <form action="" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Apa anda yakin ingin menghapus pengguna ini ?');">
                                    <input type="hidden" name="id" value="<?= $pengguna['id']; ?>">
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