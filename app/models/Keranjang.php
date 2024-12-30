<?php
class Keranjang extends BaseModel
{
    //isikan nama tabel yang ada di database untuk model ini
    protected $table = 'keranjang';

    // isikan nama kolom yang ada di dalam tabel diatas, untuk yang diizinkan disimpan
    protected $fillable = ['id_pelanggan'];

    public function __construct()
    {
        parent::__construct();
    }

    public function selectAll(): array
    {
        return parent::selectAll();
    }

    public function selectById($id): array|bool
    {
        return parent::selectById($id);
    }

    public function selectByPelanggan($pelanggan_id): array|bool
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id_pelanggan=:pelanggan_id");

            $stmt->bindParam(':pelanggan_id', $pelanggan_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

    public function saveKeranjang(array $data): int|bool
    {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);

            // Bind the values
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            if ($stmt->execute()) {
                return (int) $this->db->lastInsertId();
            }

            return false;
        } catch (PDOException $e) {
            throw new Exception("Error saving data to $this->table: " . $e->getMessage());
        }
    }

    public function delete($id): bool
    {
        return parent::delete($id);
    }

    public function deleteByPelanggan($id_pelanggan): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id_pelanggan=:id_pelanggan");
            $stmt->bindParam(':id_pelanggan', $id_pelanggan);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting data from $this->table: " . $e->getMessage());
        }
    }

    public function keranjangByPelanggan($pelanggan_id): array
    {
        try {
            $stmt = $this->db->prepare("SELECT k.*, dk.*, p.photo, p.nama AS nama_produk, plg.nama AS nama_pelanggan 
            FROM $this->table as k 
            JOIN detail_keranjang dk ON k.id = dk.id_keranjang 
            JOIN pelanggan plg ON k.id_pelanggan = plg.id
            JOIN produk p ON p.id = dk.id_produk 
            WHERE k.id_pelanggan=:pelanggan_id");

            $stmt->bindParam(':pelanggan_id', $pelanggan_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

    public function keranjangWithDetail(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT k.*, dk.*, p.photo, p.nama AS nama_produk, plg.nama AS nama_pelanggan
            FROM $this->table as k 
            JOIN detail_keranjang dk ON k.id = dk.id_keranjang 
            JOIN pelanggan plg ON k.id_pelanggan = plg.id
            JOIN produk p ON p.id = dk.id_produk");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }
}
