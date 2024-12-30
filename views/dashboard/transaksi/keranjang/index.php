<?php
$cKeranjang = new KeranjangController();
$cDKeranjang = new DetailKeranjangController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && $_POST['aksi'] === 'hapus') {
        // validasi CSRF token
        if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
            // Process delete
            $result = $cDKeranjang->hapusDKeranjang($_POST['id']);
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
        } else {
            $_SESSION['message'] = 'Token CSRF tidak valid';
        }
        header("Location: ?menu=transaksi&sub=keranjang");  // Redirect after action
        exit;
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-4">
            <table id="table" class="table mt-2">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Foto</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $cKeranjang->keranjangDetail();
                    foreach ($data as $k) { ?>
                        <tr>
                            <td class="font-weight-bold"><mark><?= $k['nama_produk']; ?></mark></td>
                            <td><img src="<?= $k['photo']; ?>" alt="foto <?= $k['nama_produk']; ?>" class="img-fluid"
                                    style="max-width: 100px">
                            </td>
                            <td><?= $k['jumlah']; ?></td>
                            <td><?= number_format($k['harga_satuan'], 0, ',', '.'); ?></td>
                            <td><?= number_format($k['jumlah'] * $k['harga_satuan'], 0, ',', '.'); ?>
                            <td><?= $k['nama_pelanggan']; ?></td>
                            <td>
                                <!-- Tombol Delete -->
                                <form action="" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Apa anda yakin ingin menghapus detail produk untuk keranjang ini ?');">
                                    <input type="hidden" name="id" value="<?= $k['id']; ?>">
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
        ],
        order: [[5, 'asc']],
        rowGroup: {
            dataSrc: 5,
            startRender: function (rows, group) {
                return $('<tr/>')
                    .append('<td colspan="8" style="background-color: #f1f1f1;">Pelanggan : <span style="font-weight: bold;">' + group + '</span></td>');
            }
        }
    });
</script>