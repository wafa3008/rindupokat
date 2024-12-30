<?php
class PesananController
{
    private $pesanan;
    private $detailPesanan;

    public function __construct()
    {
        $this->pesanan = new Pesanan();
        $this->detailPesanan = new DetailPesanan();
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (empty($data['status'])) {
            $errors['status'] = "Status must be a valid string.";
        }

        return $errors;
    }

    public function semuaPesanan(): array|bool
    {
        return $this->pesanan->selectAll();
    }

    public function pesananByID($id): array|bool
    {
        return $this->pesanan->selectById($id);
    }

    public function hapus($id): array|bool
    {
        return $this->pesanan->delete(id: $id);
    }

    public function ubah($id, $data): array
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->pesanan->edit($id, $data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses mengubah data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat mengubah data'];
    }

    public function detailByPesananID($id_pesanan): array
    {
        return $this->detailPesanan->selectByPesanan($id_pesanan);
    }
}
