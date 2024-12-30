<?php
class Pelanggan extends BaseModel
{
    //isikan nama tabel yang ada di database untuk model ini
    protected $table = 'pelanggan';

    // isikan nama kolom yang ada di dalam tabel diatas, untuk yang diizinkan disimpan
    protected $fillable = ['nama', 'telp', 'alamat'];

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
}
