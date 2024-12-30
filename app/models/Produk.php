<?php
class Produk extends BaseModel
{
    //isikan nama tabel yang ada di database untuk model ini
    protected $table = 'produk';

    // isikan nama kolom yang ada di dalam tabel diatas, untuk yang diizinkan disimpan
    protected $fillable = ['nama', 'harga', 'stock', 'deskripsi', 'photo', 'kategori_id'];

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

    public function save(array $data): bool
    {
        return parent::save($data);
    }

    public function edit($id, array $data): bool
    {
        return parent::edit($id, $data);
    }

    public function delete($id): bool
    {
        return parent::delete($id);
    }

    public function latestProduk(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT p.*, k.nama as nama_kategori FROM $this->table as p JOIN kategori k ON p.kategori_id = k.id ORDER BY p.id DESC LIMIT 6");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

    public function produkByKategori($kategori = '%'): array
    {
        try {
            if ($kategori === 'semua' || empty($kategori)) {
                $kategori = '%';
            }

            $stmt = $this->db->prepare("SELECT p.*, k.nama as nama_kategori FROM $this->table as p JOIN kategori k ON p.kategori_id = k.id WHERE k.nama LIKE :kategori");
            $stmt->bindParam(':kategori', $kategori);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

    public function cariProduk($keyword = ''): array
    {
        $keyword = "{$keyword}%";

        try {
            $stmt = $this->db->prepare("SELECT p.*, k.nama as nama_kategori FROM $this->table as p JOIN kategori k ON p.kategori_id = k.id WHERE p.nama LIKE :keyword");

            $stmt->bindParam(':keyword', $keyword);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

}
