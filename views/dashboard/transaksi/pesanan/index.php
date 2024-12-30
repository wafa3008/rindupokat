<?php
$cPesanan = new PesananController();

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
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-4">
            <table id="table" class="table table-striped my-2">
                <thead>
                    <tr>
                        <th class="dt-control" name="dt-control"></th>
                        <th>ID</th>
                        <th>Tgl Pesanan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $cPesanan->semuaPesanan();
                    foreach ($data as $pesanan) {
                        $detailPesanan = $cPesanan->detailByPesananID($pesanan['id']);
                        ?>
                        <tr data-id="<?= $pesanan['id']; ?>">
                            <td class="dt-control" name="dt-control"></td>
                            <td><?= $pesanan['id']; ?></td>
                            <td><?= $pesanan['tgl_pesanan']; ?></td>
                            <td><?= number_format($pesanan['total'], 0, ',', '.'); ?></td>
                            <td><?= $pesanan['status']; ?></td>
                            <td>
                                <a href="<?= getBaseUrl() . "dashboard.php?" . $dashboard->getQueryURL() . "&aksi=edit&id=" . $pesanan['id']; ?>"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <!-- Tombol Delete -->
                                <form action="" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Apa anda yakin ingin menghapus pesanan ini ?');">
                                    <input type="hidden" name="id" value="<?= $pesanan['id']; ?>">
                                    <input type="hidden" name="aksi" value="hapus">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                    <!-- CSRF token -->
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Pass the product details for each order as a JavaScript variable -->
                        <script>
                            var details_<?= $pesanan['id']; ?> = <?php echo json_encode($detailPesanan); ?>;
                        </script>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        function format(d) {
            var orderId = $(d).closest('tr').data('id'); // Get orderId from the row data-id attribute
            var details = window['details_' + orderId] || []; // Fetch the correct details

            // Create the table HTML structure for product details
            var tableHtml = '<table class="table table-bordered">' +
                '<thead>' +
                '<tr>' +
                '<th>Nama Produk</th>' +
                '<th>Jumlah</th>' +
                '<th>Harga Satuan</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

            // Loop through each product and add a row to the table
            details.forEach(function (detail) {
                tableHtml += '<tr>' +
                    '<td>' + detail.nama_produk + '</td>' +
                    '<td>' + detail.jumlah + '</td>' +
                    '<td>' + detail.harga_satuan + '</td>' +
                    '</tr>';
            });

            tableHtml += '</tbody></table>';
            return tableHtml;
        }

        var table = $('#table').DataTable({
            columnDefs: [{ orderable: false, targets: 0 }],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ]
        });

        // Add a click event to the rows to toggle the child row visibility
        table.on('click', 'td.dt-control', function (e) {
            let tr = e.target.closest('tr');
            let row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
            }
            else {
                // Open this row
                row.child(format(tr)).show();
            }
        });
    });
</script>