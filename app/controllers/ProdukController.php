<?php
class ProdukController
{
    private $produk;

    public function __construct()
    {
        $this->produk = new Produk();
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (empty($data['nama'])) {
            $errors['nama'] = "Nama produk is required.";
        }

        if (empty($data['harga']) || !is_numeric($data['harga']) || $data['harga'] <= 0) {
            $errors['harga'] = "Harga produk must be a positive number.";
        }

        if (empty($data['stock']) || !is_numeric($data['stock']) || $data['stock'] < 0) {
            $errors['stock'] = "Stock produk must be a non-negative integer.";
        }

        if (empty($data['deskripsi'])) {
            $errors['deskripsi'] = "Deskripsi produk must be a valid string.";
        }

        if (empty($data['kategori_id'])) {
            $errors['kategori_id'] = "Kategori tidak boleh kosong";
        }

        if (!isset($data['photo'])) {
            $errors['photo'] = "File yang didukung jpg, png & gif, dengan ukuran maksimal 1MB";
        }

        return $errors;
    }

    public function produkKategori($kategori): array
    {
        return $this->produk->produkByKategori($kategori);
    }

    public function semuaProduk(): array
    {
        return $this->produk->selectAll();
    }

    public function produkById($id): array|bool
    {
        return $this->produk->selectById($id);
    }

    public function tambahproduk($data): array
    {
        if (isset($_FILES['photo'])) {
            $uploadedPhoto = $this->uploadPhoto($_FILES['photo'], $data['nama']);
            if ($uploadedPhoto) {
                $data['photo'] = $uploadedPhoto; // Add the photo path to the data
            }
        }

        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->produk->save($data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menambahkan data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menambahkan data'];
    }

    public function ubahproduk($id, $data): array
    {
        if (isset($_FILES['photo'])) {
            $uploadedPhoto = $this->uploadPhoto($_FILES['photo'], $data['nama']);
            if ($uploadedPhoto) {
                $data['photo'] = $uploadedPhoto; // Add the photo path
            }
        }

        $errors = $this->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        $success = $this->produk->edit($id, $data);
        return $success ? ['icon' => 'success', 'message' => 'Sukses mengubah data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat mengubah data'];
    }

    public function hapusproduk($id): array
    {
        $success = $this->produk->delete($id);
        return $success ? ['icon' => 'success', 'message' => 'Sukses menghapus data']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan saat menghapus data'];
    }

    public function uploadPhoto($file, $namafoto): string|false
    {
        // Check if file was uploaded
        if ($file['error'] == 0) {
            $targetDir = "./assets/images/produk/";
            // Ensure the directory exists, if not, create it
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Get the file extension
            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Generate the new filename using the Unix timestamp
            $newFileName = time() . str_replace(' ', '_', $namafoto) . '.' . $fileExtension;
            $targetFile = $targetDir . $newFileName;

            // Check file type (you can modify this as needed)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                return false;
            }

            // Check file size (optional)
            if ($file['size'] > 1000000) { // 1MB max size
                return false;
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                return $targetFile; // Return the path of the uploaded photo
            } else {
                return false;
            }
        }

        return false; // Return false if file upload failed
    }
}
