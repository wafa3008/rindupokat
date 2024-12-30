<?php
$cKategori = new KategoriController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && $_POST['aksi'] === 'hapus') {
        // validasi CSRF token
        if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
            // Process delete
            $result = $cKategori->hapuskategori($_POST['id']);
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
        } else {
            $_SESSION['message'] = 'Token CSRF tidak valid';
        }
        header("Location: ?menu=shop&sub=kategori");  // Redirect after action
        exit;
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><a class="btn btx-xs btn-success"
                    href="<?= getBaseUrl() . "dashboard.php?" . $dashboard->getQueryURL() . "&aksi=tambah"; ?>"><i
                        class="fas fa-plus"></i> Kategori</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-4">
            <table id="table" class="table table-striped mt-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Size</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $cKategori->semuaKategori();
                    foreach ($data as $kategori) { ?>
                        <tr>
                            <td><?= $kategori['id']; ?></td>
                            <td><?= $kategori['nama']; ?></td>
                            <td><?= $kategori['deskripsi']; ?></td>
                            <td><?= $kategori['size']; ?></td>
                            <td>
                                <a href="<?= getBaseUrl() . "dashboard.php?" . $dashboard->getQueryURL() . "&aksi=edit&id=" . $kategori['id']; ?>"
                                    class="btn btn-sm btn-warning">Edit</a>

                                <form action="" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Apa anda yakin ingin menghapus kategori ini ?');">
                                    <input type="hidden" name="id" value="<?= $kategori['id']; ?>">
                                    <input type="hidden" name="aksi" value="hapus">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
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