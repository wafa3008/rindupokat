<?php
$cProduk = new ProdukController();
$cKategori = new KategoriController();
$selectedCategory = isset($_POST['kategori']) ? $_POST['kategori'] : 'semua';
?>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .footer {
        text-align: center;
        margin-top: 30px;
    }

    @media print {
        .print-button {
            display: none;
        }

        form,
        footer {
            display: none;
        }
    }
</style>

<div class="header">
    <h2>Laporan Produk</h2>
    <p>Daftar seluruh produk yang tersedia</p>
</div>

<form method="POST" action="" class="mb-4">
    <label for="kategori_id" class="me-1">Filter By Kategori : </label>
    <div class="d-flex d-inline-flex justify-content-center align-items-center">
        <select class="custom-select form-control-border border-width-2" id="kategori" name="kategori">
            <option value="semua" <?= ($selectedCategory === 'semua') ? 'selected' : '' ?>>Semua</option>
            <?php foreach ($cKategori->semuaKategori() as $kategori) { ?>
                <option value="<?= $kategori['nama'] ?>" <?= ($selectedCategory === $kategori['id']) ? 'selected' : '' ?>>
                    <?= $kategori['nama'] ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" class="btn btn-primary ml-1">Filter</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Stock</th>
            <th class="text-center">Kategori</th>
            <th class="text-center">Photo</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $no = 1;

        $produkList = $cProduk->produkKategori($selectedCategory);
        if (empty($produkList)) {
            // If no data is found, show a "Data Tidak Ditemukan" message with colspan
            echo '<tr><td colspan="7" class="text-center">Data Tidak Ditemukan</td></tr>';
        } else {
            foreach ($produkList as $produk) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . htmlspecialchars($produk['nama']) . '</td>';
                echo '<td>' . htmlspecialchars($produk['deskripsi']) . '</td>';
                echo '<td class="text-center">Rp ' . number_format($produk['harga'], 0, ',', '.') . '</td>';
                echo '<td class="text-center">' . htmlspecialchars($produk['stock']) . '</td>';
                echo '<td class="text-center">' . htmlspecialchars($produk['nama_kategori']) . '</td>';
                echo '<td class="text-center"><img src="' . $produk['photo'] . '" alt="foto ' . htmlspecialchars($produk['nama']) . '" class="img-fluid" style="max-width: 100px"></td>';
                echo '</tr>';
            }
        }
        ?>

    </tbody>
</table>

<div class="footer">
    <button class="print-button" onclick="window.print()">Cetak Laporan</button>
</div>