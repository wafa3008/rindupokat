<?php
// Handle checkout action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aksi']) && $_POST['aksi'] === 'checkout') {
        $data = $_POST;
        print_r($data);

        $result = $cHome->checkout($data);
        //jika terdapat error
        if (!array_key_exists('icon', $result) && !array_key_exists('message', $result) && !empty($result)) {
            $errors = $result; // simpan error
        } else {
            unset($_POST);
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
            header("Location: ?menu=keranjang");
            exit;
        }
    }
}
?>

<?php if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id_pelanggan'])): ?>
    <div class="container">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-flex card-title align-items-center fw-bold"><i
                            class="bi bi-bag-heart-fill me-1 bg-danger rounded text-white p-1"></i>Keranjang Anda</a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-4">
                    <table id="table" class="table table-striped my-2">
                        <thead>
                            <tr>
                                <th>ID Produk</th>
                                <th>Nama Produk</th>
                                <th>Foto</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = $cHome->keranjangPelanggan($_SESSION['user']['id_pelanggan'] ?? null);
                            $grandTotal = 0;
                            foreach ($data as $keranjang) { ?>
                                <tr>
                                    <td><?= $keranjang['id_produk']; ?></td>
                                    <td><?= $keranjang['nama_produk']; ?></td>
                                    <td><img src="<?= $keranjang['photo']; ?>" alt="foto <?= $keranjang['nama_produk']; ?>"
                                            class="img-fluid" style="max-width: 100px">
                                    </td>
                                    <td><input type="number" name="jumlah" min="0" value="<?= $keranjang['jumlah']; ?>"
                                            style="width:70px; text-align:center"></td>
                                    <td><?= number_format($keranjang['harga_satuan'], 0, ',', '.'); ?></td>
                                    <td><?= number_format($keranjang['jumlah'] * $keranjang['harga_satuan'], 0, ',', '.'); ?>
                                    </td>
                                    <td>
                                        <!-- Tombol Delete -->
                                        <form action="" method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('Apa anda yakin ingin menghapus produk ini ?');">
                                            <input type="hidden" name="id" value="<?= $keranjang['id']; ?>">
                                            <input type="hidden" name="aksi" value="hapus">
                                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                            <!-- CSRF token -->
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                $grandTotal += $keranjang['jumlah'] * $keranjang['harga_satuan'];
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold fs-6">
                                <td colspan="6" style="text-align:right">Total Belanja :</td>
                                <td id="totalCheckout"><?= number_format($grandTotal, 0, ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <!-- Checkout Form -->
                    <form action="" method="POST" id="checkoutForm"
                        onsubmit="return confirm('Seluruh keranjang akan dilakukan transaksi ?');">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="aksi" value="checkout">
                        <button type="submit" class="btn btn-success fw-bold" id="checkoutButton">
                            <i class="bi bi-send-check-fill me-1"></i>Checkout
                        </button>
                    </form>
                </div>
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

        function updateTotalCheckout() {
            let grandTotal = 0;
            $('#table tbody tr').each(function () {
                var row = $(this);
                var qty = row.find('input[name="jumlah"]').val();
                var price = row.find('td').eq(4).text().replace(/\./g, '');
                var total = qty * price;
                grandTotal += total;
            });

            $('#totalCheckout').text(grandTotal.toLocaleString('id-ID'));
        }

        $('#table').on('change', 'input[name="jumlah"]', function () {
            var row = $(this).closest('tr');
            var qty = $(this).val();
            var price = row.find('td').eq(4).text().replace(/\./g, '');
            var total = qty * price;
            row.find('td').eq(5).text(total.toLocaleString('id-ID'));

            updateTotalCheckout();
        });
    </script>

    <script>
        function getDataFromTable() {
            var tableData = [];
            $('#table').DataTable().rows().every(function () {
                var row = this.node();
                var id = $(row).find('td').eq(0).text();
                var name = $(row).find('td').eq(1).text();
                var qty = $(row).find('input[name="jumlah"]').val();
                var price = $(row).find('td').eq(4).text().replace(/\./g, '');
                var total = qty * price;

                tableData.push({
                    id: id,
                    name: name,
                    qty: qty,
                    price: price,
                    total: total
                });

                $(row).find('td').eq(5).text(total.toLocaleString('id-ID'));
            });

            tableData.forEach(function (item, index) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'pesanan[' + index + '][id]',
                    value: item.id
                }).appendTo('#checkoutForm');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'pesanan[' + index + '][name]',
                    value: item.name
                }).appendTo('#checkoutForm');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'pesanan[' + index + '][qty]',
                    value: item.qty
                }).appendTo('#checkoutForm');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'pesanan[' + index + '][price]',
                    value: item.price
                }).appendTo('#checkoutForm');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'pesanan[' + index + '][total]',
                    value: item.total
                }).appendTo('#checkoutForm');
            });
        }

        $('#checkoutButton').click(function (e) {
            e.preventDefault();
            getDataFromTable();

            $('#checkoutForm').submit();
        });
    </script>
<?php else: ?>
    <?php include 'layouts/404.php' ?>
<?php endif; ?>