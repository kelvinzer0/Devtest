<?php
require 'database/mysql.php';
require 'utils/converter.php';

class DataRepository
{
    public $db;
    public $connection;
    public function __construct()
    {
        $this->db = new DatabasePool(10);
        $this->connection = $this->db->getConnection();
    }

    public function GetAll($limit = 10, $offset = 0, $deleted = false)
    {
        if ($deleted) {
            $sql = "SELECT * FROM users WHERE deleted_at IS NOT NULL LIMIT $limit OFFSET $offset";
        } else {
            $sql = "SELECT * FROM users WHERE deleted_at IS NULL LIMIT $limit OFFSET $offset";
        }
        $result = $this->connection->query($sql);
        $data = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        } else {
            echo "Error: " . $this->connection->error;
        }
        return $data;
    }

    public function GetOne($id)
    {
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $this->connection->query($sql);
        return $result;
    }

    public function Create($data)
    {
        $nama = setIfUnset($data['nama']);
        $tanggal_lahir = setIfUnset($data['tanggal_lahir']);
        $alamat = setIfUnset($data['alamat']);
        $is_active = setIfUnset($data['is_active']);
        $password_hash = setIfUnset($data['password_hash']);
        $password_algorithm = setIfUnset($data['password_algorithm']);

        $sql = "INSERT INTO users (nama, tanggal_lahir, alamat, is_active, password_hash, password_algorithm) VALUES ('$nama', '$tanggal_lahir', '$alamat', $is_active, '$password_hash', '$password_algorithm') RETURNING *;";
        $result = $this->connection->query($sql);
        if($result){
            $out = $result->fetch_assoc();
        } else {
            echo "Error: ". $this->connection->error;
        }
        return $out;
    }

    public function Update($data)
    {
        $id = setIfUnset($data['id']);
        $nama = setIfUnset($data['nama']);
        $tanggal_lahir = $data['tanggal_lahir'];
        $alamat = setIfUnset($data['alamat']);
        $is_active = setIfUnset($data['is_active']);
        $password_hash = setIfUnset($data['password_hash']);
        $password_algorithm = setIfUnset($data['password_algorithm']);
        $updated_at = date('Y-m-d H:i:s');
        $sql = "UPDATE users SET nama = '$nama', tanggal_lahir = '$tanggal_lahir', alamat = '$alamat', is_active = $is_active, password_hash='$password_hash', password_algorithm = '$password_algorithm', updated_at='$updated_at' WHERE id = $id;";
        $result = $this->connection->query($sql);
        return $result;
    }

    public function Delete($id, $soft_delete)
    {
        if ($soft_delete) {
            $sql = "UPDATE users SET deleted_at = NOW() WHERE id = $id";
        } else {
            $sql = "DELETE FROM users WHERE id = $id";
        }
        $result = $this->connection->query($sql);
        return $result;
    }

    public function LastInsert(){
        $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
        $result = $this->connection->query($sql);
        return $result;
    }


}