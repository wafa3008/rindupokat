<?php
class AuthController
{
    private $pengguna;
    private $pelanggan;

    public function __construct()
    {
        $this->pengguna = new Pengguna();
        $this->pelanggan = new Pelanggan();
    }

    private function validateLogin(array $data): array
    {
        $errors = [];

        if (empty($data['password'])) {
            $errors['password'] = "Password is required.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email address.";
        }

        return $errors;
    }

    private function validateRegister(array $data): array
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = "Username is required.";
        }

        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors['password'] = "Password must be at least 8 characters long.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email address.";
        }

        if (!empty($this->pengguna->search('username', $data['username']))) {
            $errors['username'] = "Username is allready taken";
        }

        if (!empty($this->pengguna->search('email', $data['email']))) {
            $errors['email'] = "Email is allready taken";
        }

        if (empty($data['nama'])) {
            $errors['nama'] = "Nama Lengkap is required.";
        }

        if (empty($data['telp'])) {
            $errors['telp'] = "No. Telp is required.";
        }

        if (empty($data['alamat'])) {
            $errors['alamat'] = "Alamat is required.";
        }

        return $errors;
    }

    public function daftar($data)
    {

        $errors = $this->validateRegister($data);

        if (!empty($errors)) {
            return $errors;
        }

        $dataPelanggan = [
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'telp' => $data['telp']
        ];

        $dataPengguna = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password']
        ];

        $pelangganId = $this->pengguna->savePelanggan($dataPelanggan);

        if ($pelangganId) {
            $dataPengguna['id_pelanggan'] = $pelangganId;

            $success = $this->pengguna->save($dataPengguna);

            if (!$success) {
                $this->pelanggan->delete($pelangganId);
            }
        } else {
            $success = false;
        }

        $_SESSION['icon_message'] = $success ? 'success' : 'error';
        $_SESSION['message'] = $success ? 'Registrasi Berhasil, Silahkan Login' : 'Terjadi Kesalahan, Registrasi Gagal';

        return (bool) $success;
    }

    public function masuk($data)
    {
        $errors = $this->validateLogin($data);

        if (!empty($errors)) {
            return $errors;
        }

        $result = $this->pengguna->login($data['email'], $data['password']);

        $_SESSION['icon_message'] = $result ? 'success' : 'error';
        $_SESSION['message'] = $result ? 'Berhasil Login' : 'Username dan Password tidak ditemukan';

        if ($result) {
            $_SESSION['user'] = $result;
        }

        return (bool) $result;
    }

    public function keluar()
    {
        unset($_SESSION['user']);
        session_destroy();
        session_start();
        $_SESSION['icon_message'] = 'success';
        $_SESSION['message'] = 'Anda berhasil keluar dari sesi ini';
    }

}
