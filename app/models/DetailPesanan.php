<?php
class DetailPesanan extends BaseModel
{
    //isikan nama tabel yang ada di database untuk model ini
    protected $table = 'detail_pesanan';

    // isikan nama kolom yang ada di dalam tabel diatas, untuk yang diizinkan disimpan
    protected $fillable = ['id_pesanan', 'id_produk', 'jumlah', 'harga_satuan'];

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

    public function selectByPesanan($id_pesanan): array|bool
    {
        try {
            $stmt = $this->db->prepare("SELECT dps.*, prd.nama as nama_produk FROM $this->table dps 
            JOIN produk prd ON dps.id_produk = prd.id 
            WHERE id_pesanan=:id_pesanan");

            $stmt->bindParam(':id_pesanan', $id_pesanan);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
