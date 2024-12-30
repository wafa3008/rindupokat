<?php if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id_pelanggan'])): ?>
    <div class="container">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-flex card-title align-items-center fw-bold">
                        <i class="bi bi-cart-fill me-1 bg-success rounded text-white p-1"></i>Riwayat Pesanan
                    </h3>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = $cHome->pesananPelanggan($_SESSION['user']['id_pelanggan'] ?? null);
                            foreach ($data as $pesanan) {
                                $detailPesanan = $cHome->detailPesanan($pesanan['id']);
                                ?>
                                <tr data-id="<?= $pesanan['id']; ?>">
                                    <td class="dt-control" name="dt-control"></td>
                                    <td><?= $pesanan['id']; ?></td>
                                    <td><?= $pesanan['tgl_pesanan']; ?></td>
                                    <td><?= number_format($pesanan['total'], 0, ',', '.'); ?></td>
                                    <td><?= $pesanan['status']; ?></td>
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
<?php else: ?>
    <?php include 'layouts/404.php' ?>
<?php endif; ?>