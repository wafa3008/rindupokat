<?php
class DetailKeranjangController
{
    private $detailKeranjang;

    public function __construct()
    {
        $this->detailKeranjang = new DetailKeranjang();
    }

    public function hapusDKeranjang($id): array
    {
        $success = $this->detailKeranjang->delete($id);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menghapus data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menghapus data'];
    }

}
