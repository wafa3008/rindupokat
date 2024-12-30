<?php
class KategoriController
{
    private $kategori;

    public function __construct()
    {
        $this->kategori = new Kategori();
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (empty($data['nama'])) {
            $errors['nama'] = "Nama kategori is required.";
        }

        if (empty($data['deskripsi'])) {
            $errors['deskripsi'] = "Deskripsi kategori must be a valid string.";
        }

        if (empty($data['size'])) {
            $errors['size'] = "size kategori must be a valid string.";
        }

        return $errors;
    }

    public function semuaKategori(): array
    {
        return $this->kategori->selectAll();
    }

    public function kategoriById($id): array|bool
    {
        return $this->kategori->selectById($id);
    }

    public function tambahkategori($data): array
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->kategori->save($data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menambahkan data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menambahkan data'];
    }

    public function ubahkategori($id, $data): array
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->kategori->edit($id, $data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses mengubah data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat mengubah data'];
    }

    public function hapuskategori($id): array
    {
        $success = $this->kategori->delete($id);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menghapus data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menghapus data'];
    }

}
