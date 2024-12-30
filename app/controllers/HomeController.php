<?php
class HomeController
{

    private $queryUrl;
    private $menu;
    private $isValid;
    private $produk;
    private $kategori;
    private $keranjang;
    private $detailKeranjang;
    private $pesanan;
    private $detailPesanan;

    const VALID_MENU = [
        'produk',
        'keranjang',
        'pesanan'
    ];

    const DEFAULT_MENU = 'home';

    public function __construct($queryUrl)
    {
        $this->produk = new Produk();
        $this->kategori = new Kategori();
        $this->keranjang = new Keranjang();
        $this->detailKeranjang = new DetailKeranjang();
        $this->pesanan = new Pesanan();
        $this->detailPesanan = new DetailPesanan();

        $this->queryUrl = $queryUrl ?? '';
        $this->parseQueryUri();
        $this->validateUri();
    }

    private function parseQueryUri()
    {
        parse_str($this->queryUrl, $parameters);
        $this->menu = $parameters['menu'] ?? self::DEFAULT_MENU;
    }

    private function validateUri()
    {
        // If the menu is 'home', skip normal validation and treat it as valid
        if ($this->menu === 'home') {
            $this->isValid = true;
        } else {
            $this->isValid = $this->isValidUri();
        }
    }

    private function isValidUri()
    {
        // Validate the menu, sub-menu, and action in one go
        return in_array($this->menu, self::VALID_MENU, true);
    }

    public function getContentPath()
    {
        // If the menu is 'home', return the default path
        if ($this->menu === 'home') {
            $path = "./views/home/index.php";
        } else {
            $path = "./views/home/{$this->menu}.php";
        }
        return $this->isValid ? realpath($path) : false;
    }

    //Bagian Tampilan Produk
    public function produkTerkini(): array
    {
        return $this->produk->latestProduk();
    }

    public function kategoris(): array
    {
        return $this->kategori->selectAll();
    }

    public function produkKategori($kategori): array
    {
        return $this->produk->produkByKategori($kategori);
    }

    public function findProduk($keyword): array
    {
        return $this->produk->cariProduk($keyword);
    }

    // bagian tampilan keranjang
    public function keranjangPelanggan($pelanggan_id): array
    {
        return $this->keranjang->keranjangByPelanggan($pelanggan_id);
    }

    public function tambahKeranjang($data): array
    {
        // Start a database transaction
        $this->keranjang->getDB()->beginTransaction();

        try {
            $id_pelanggan = $_SESSION['user']['id_pelanggan'] ?? null;

            // Ambil keranjang saat ini atau buat baru jika tidak ada
            $keranjang = $this->keranjang->selectByPelanggan($id_pelanggan);
            $id_keranjang = $keranjang ? $keranjang['id'] : $this->keranjang->saveKeranjang(['id_pelanggan' => $id_pelanggan]);

            if (!$id_keranjang) {
                throw new Exception('Terjadi kesalahan saat menambahkan data');
            }

            //ambil data produk
            $produk = $this->produk->selectById($data['id_produk']);
            if (!$produk) {
                throw new Exception('Produk tidak ditemukan');
            }

            // cek stok tersedia
            if ($produk['stock'] < $data['jumlah']) {
                throw new Exception('Stok tidak cukup');
            }

            // set nilai detail keranjang
            $detailKeranjang = [
                'id_keranjang' => $id_keranjang,
                'id_produk' => $data['id_produk'],
                'jumlah' => $data['jumlah'],
                'harga_satuan' => $produk['harga']
            ];

            //cek apakah produk sudah ada dikeranjang
            $produkKeranjang = $this->detailKeranjang->selectByProduk($id_keranjang, $data['id_produk']);

            if ($produkKeranjang) {
                //jika ada update jumlah kuantitas nya
                if ($produk['stock'] < ($produkKeranjang['jumlah'] + $data['jumlah'])) {
                    throw new Exception('Stok tidak cukup untuk menambah jumlah produk');
                }

                $detailKeranjang['jumlah'] += $produkKeranjang['jumlah']; // Add the new quantity
                $success = $this->detailKeranjang->edit($produkKeranjang['id'], $detailKeranjang);
            } else {
                // jika tidak ada tambahkan detail produk baru
                $success = $this->detailKeranjang->save($detailKeranjang);
            }

            // If saving the cart detail fails, throw an exception
            if (!$success) {
                throw new Exception('Terjadi kesalahan saat menambahkan data');
            }

            // If everything is successful, commit the transaction
            $this->keranjang->getDB()->commit();

            return ['icon' => 'success', 'message' => 'Sukses menambahkan data'];
        } catch (Exception $e) {
            // If any error occurs, roll back the transaction
            $this->keranjang->getDB()->rollBack();

            // Return error message
            return ['icon' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Bagian Tampilan Pesanan
    public function checkout($data): array
    {
        $id_pelanggan = $_SESSION['user']['id_pelanggan'] ?? null;

        $dataPesanan = [
            'id_pelanggan' => $id_pelanggan,
            'tgl_pesanan' => date('Y-m-d'),
            'status' => 'Menunggu konfirmasi'
        ];

        $id_pesanan = $this->pesanan->savePesanan($dataPesanan);

        if (!$id_pesanan) {
            return ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menambahkan data'];
        }

        foreach ($data['pesanan'] as $pesanan) {
            $produk = $this->produk->selectById($pesanan['id']);

            print_r($produk);

            // cek stok
            if ($produk['stock'] < $pesanan['qty']) {
                return ['icon' => 'error', 'message' => "Stok tidak mencukupi untuk beberapa produk dipilih"];
            }
        }

        foreach ($data['pesanan'] as $pesanan) {
            $produk = $this->produk->selectById($pesanan['id']);
            $dataDKeranjang = [
                'id_pesanan' => $id_pesanan,
                'id_produk' => $produk['id'],
                'jumlah' => $pesanan['qty'],
                'harga_satuan' => $produk['harga']
            ];

            $success = $this->detailPesanan->save($dataDKeranjang);
        }

        if (!$success) {
            $this->pesanan->delete($id_pesanan);
            return ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menambahkan data'];
        } else {
            //kosongkan keranjang
            $this->keranjang->deleteByPelanggan($id_pelanggan);
        }

        return ['icon' => 'success', 'message' => 'Sukses menambahkan data'];
    }

    public function pesananPelanggan($pelanggan_id): array
    {
        return $this->pesanan->selectByPelanggan($pelanggan_id);
    }

    public function detailPesanan($id_pesanan): array
    {
        return $this->detailPesanan->selectByPesanan($id_pesanan);
    }

}
