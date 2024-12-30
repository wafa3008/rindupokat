<?php

class PenggunaController
{
    private $pengguna;

    public function __construct()
    {
        $this->pengguna = new Pengguna();
    }

    private function validate(array $data, $isEdit = false): array
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = "username pengguna is required.";
        }

        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors['password'] = "Password must be at least 8 characters long.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email address.";
        }

        return $errors;
    }

    public function semuaPengguna(): array
    {
        return $this->pengguna->selectAll();
    }

    public function penggunaById($id): array|bool
    {
        return $this->pengguna->selectById($id);
    }

    public function tambahpengguna($data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->pengguna->save($data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menambahkan data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menambahkan data'];
    }

    public function ubahpengguna($id, $data): array
    {

        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->pengguna->edit($id, $data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses mengubah data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat mengubah data'];
    }

    public function hapuspengguna($id): array
    {
        $success = $this->pengguna->delete($id);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menghapus data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menghapus data'];
    }

}
