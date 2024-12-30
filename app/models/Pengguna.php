<?php
class Pengguna extends BaseModel
{
    //isikan nama tabel yang ada di database untuk model ini
    protected $table = 'pengguna';

    // isikan nama kolom yang ada di dalam tabel diatas, untuk yang diizinkan disimpan
    protected $fillable = ['username', 'password', 'email', 'id_pelanggan'];

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
        try {
            $data = $this->filterData($data);

            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

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

            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

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
        return parent::delete($id);
    }

    public function search($column, $keyword): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE $column=:keyword");
            $stmt->bindParam(':keyword', $keyword);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error data not found from $this->table: " . $e->getMessage());
        }
    }

    public function login($email, $password): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return [];
        } catch (PDOException $e) {
            throw new Exception("Error data not found from $this->table: " . $e->getMessage());
        }
    }

    public function register(array $data): bool
    {
        try {
            $data = $this->filterData($data);

            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

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

    public function savePelanggan(array $data): int|bool
    {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO pelanggan ($columns) VALUES ($placeholders)";
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
            throw new Exception("Error saving data to Pelanggan: " . $e->getMessage());
        }
    }

}
