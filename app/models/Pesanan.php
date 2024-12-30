<?php
class Pesanan extends BaseModel
{
    //isikan nama tabel yang ada di database untuk model ini
    protected $table = 'pesanan';

    // isikan nama kolom yang ada di dalam tabel diatas, untuk yang diizinkan disimpan
    protected $fillable = ['id_pelanggan', 'tgl_pesanan', 'status'];

    public function __construct()
    {
        parent::__construct();
    }

    public function selectByPelanggan($pelanggan_id): array|bool
    {
        try {
            $stmt = $this->db->prepare("SELECT ps.*, SUM(dps.jumlah * dps.harga_satuan) as total FROM $this->table as ps 
            JOIN detail_pesanan dps ON ps.id = dps.id_pesanan  
            WHERE ps.id_pelanggan=:pelanggan_id
            GROUP BY dps.id_pesanan");

            $stmt->bindParam(':pelanggan_id', $pelanggan_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

    public function selectAll(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT ps.*, SUM(dps.jumlah * dps.harga_satuan) as total FROM $this->table as ps 
            JOIN detail_pesanan dps ON ps.id = dps.id_pesanan  
            GROUP BY dps.id_pesanan");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

    public function savePesanan(array $data): int|bool
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

    public function edit($id, array $data): bool
    {
        return parent::edit($id, $data);
    }

    public function delete($id): bool
    {
        return parent::delete($id);
    }
}
