<?php
class BaseModel
{
    protected $db;
    protected $table;
    protected $fillable = [];

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // filter data yang boleh diisi berdasarkan kolom yang ditetapkan pada Class yang mewarisi ini
    protected function filterData(array $data): array
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    public function selectAll(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all data from $this->table: " . $e->getMessage());
        }
    }

    public function selectById($id): array|bool
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching data by ID from $this->table: " . $e->getMessage());
        }
    }

    public function save(array $data): bool
    {
        try {
            $data = $this->filterData($data);

            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);

            // Bind the values
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error saving data to $this->table: " . $e->getMessage());
        }
    }

    public function edit($id, array $data): bool
    {
        try {
            $data = $this->filterData($data);

            $setPart = '';
            foreach ($data as $key => $value) {
                $setPart .= "$key = :$key, ";
            }
            $setPart = rtrim($setPart, ', ');

            $sql = "UPDATE $this->table SET $setPart WHERE id=:id";
            $stmt = $this->db->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating data in $this->table: " . $e->getMessage());
        }
    }

    public function delete($id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id=:id");
            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting data from $this->table: " . $e->getMessage());
        }
    }

    public function getDB()
    {
        return $this->db;
    }
}
