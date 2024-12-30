<?php
class DashboardController
{
    private $queryUrl;
    private $menu;
    private $sub;
    private $aksi;
    private $isValid;

    const VALID_MENU = [
        'shop' => ['produk', 'kategori', 'pelanggan'],
        'transaksi' => ['keranjang', 'pesanan'],
        'laporan' => ['produk', 'pesanan'],
        'pengaturan' => ['pengguna'],
    ];

    const VALID_AKSI = [
        'produk' => ['tambah', 'edit', 'index', 'cetak'],
        'kategori' => ['tambah', 'edit', 'index'],
        'pelanggan' => ['tambah', 'edit', 'index'],
        'keranjang' => ['index'],
        'pesanan' => ['edit', 'index', 'cetak'],
        'pengguna' => ['tambah', 'edit', 'index'],
    ];

    const DEFAULT_MENU = 'home';
    const DEFAULT_AKSI = 'index';

    public function __construct($queryUrl)
    {
        $this->queryUrl = $queryUrl ?? '';
        $this->parseQueryUri();
        $this->validateUri();
    }

    private function parseQueryUri()
    {
        parse_str($this->queryUrl, $parameters);
        $this->menu = $parameters['menu'] ?? self::DEFAULT_MENU;
        $this->sub = $parameters['sub'] ?? '';
        $this->aksi = $parameters['aksi'] ?? self::DEFAULT_AKSI;
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
        return isset(self::VALID_MENU[$this->menu])
            && (empty($this->sub) || in_array($this->sub, self::VALID_MENU[$this->menu], true))
            && (empty($this->sub) || isset(self::VALID_AKSI[$this->sub]) && in_array($this->aksi, self::VALID_AKSI[$this->sub], true));
    }

    public function getContentPath()
    {
        // If the menu is 'home', return the default path
        if ($this->menu === 'home') {
            $path = "./views/dashboard/index.php";
        } else {
            $path = "./views/dashboard/{$this->menu}/{$this->sub}/{$this->aksi}.php";
        }
        return $this->isValid ? realpath($path) : false;
    }

    public function getMenuName()
    {
        return $this->menu;
    }

    public function getSubName()
    {
        return $this->sub;
    }

    public function getAksiName()
    {
        return $this->aksi;
    }

    public function getQueryURL()
    {
        return $this->queryUrl;
    }
}
