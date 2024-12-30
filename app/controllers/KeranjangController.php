<?php
class KeranjangController
{
    private $keranjang;

    public function __construct()
    {
        $this->keranjang = new Keranjang();
    }

    public function keranjangDetail(): array|bool
    {
        return $this->keranjang->keranjangWithDetail();
    }

}
