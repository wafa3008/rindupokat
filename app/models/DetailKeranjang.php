<?php
class DetailKeranjang extends BaseModel
{
    //isikan nama tabel yang ada di database untuk model ini
    protected $table = 'detail_keranjang';

    // isikan nama kolom yang ada di dalam tabel diatas, untuk yang diizinkan disimpan
    protected $fillable = ['id_keranjang', 'id_produk', 'jumlah', 'harga_satuan'];

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

    public function selectByProduk($id_keranjang, $id_produk): array|bool
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id_produk=:id_produk AND id_keranjang=:id_keranjang");

            $stmt->bindParam(':id_keranjang', $id_keranjang);
            $stmt->bindParam(':id_produk', $id_produk);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
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

}
