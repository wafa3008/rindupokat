<?php
class PelangganController
{
    private $pelanggan;

    public function __construct()
    {
        $this->pelanggan = new Pelanggan();
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (empty($data['nama'])) {
            $errors['nama'] = "Nama pelanggan is required.";
        }

        if (empty($data['telp'])) {
            $errors['telp'] = "Telepon is required.";
        }

        if (empty($data['alamat'])) {
            $errors['alamat'] = "Alamat must be a valid string.";
        }

        return $errors;
    }

    public function semuaPelanggan(): array
    {
        return $this->pelanggan->selectAll();
    }

    public function pelangganById($id): array|bool
    {
        return $this->pelanggan->selectById($id);
    }

    public function tambahpelanggan($data): array
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->pelanggan->save($data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menambahkan data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menambahkan data'];
    }

    public function ubahpelanggan($id, $data): array
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->pelanggan->edit($id, $data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses mengubah data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat mengubah data'];
    }

    public function hapuspelanggan($id): array
    {
        $success = $this->pelanggan->delete($id);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menghapus data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menghapus data'];
    }

}
