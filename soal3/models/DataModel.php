<?php
class DataModel
{
    public $id;
    public $nama;
    public $tanggal_lahir;
    public $alamat;
    public $is_active;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function __construct($data)
    {
        $this->id = $data['id'];
        if (isset($data['nama'])) {
            $this->nama = $data['nama'];
        }
        if (isset($data['tanggal_lahir'])) {
            $this->tanggal_lahir = $data['tanggal_lahir'];
        }
        if (isset($data['alamat'])) {
            $this->alamat = $data['alamat'];
        }
        if (isset($data['is_active'])) {
            $this->is_active = $data['is_active'];
        }
        if (isset($data['created_at'])) {
            $this->created_at = $data['created_at'];
        }
        if (isset($data['updated_at'])) {
            $this->updated_at = $data['updated_at'];
        }
        if (isset($data['deleted_at'])) {
            $this->deleted_at = $data['deleted_at'];
        }
    }
}
