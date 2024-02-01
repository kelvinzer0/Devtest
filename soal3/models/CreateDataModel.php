<?php
class CreateDataModel {
    public $nama;
    public $tanggal_lahir;
    public $alamat;
    public $is_active;
    public $password;

    public function __construct($data) {
        
        $requiredProperties = ['nama', 'tanggal_lahir', 'alamat', 'is_active', 'password'];
        foreach ($requiredProperties as $property) {
            if (!isset($data[$property]) || empty($data[$property])) {
                $errors[] = "Properti '$property' diperlukan dan tidak boleh kosong.";
            }
        }
        if (!empty($errors)) {
            $errorMessage = json_encode(['errors' => $errors], JSON_PRETTY_PRINT);
            echo $errorMessage;
            exit();
        }

        $this->nama = $data['nama'];
        $this->tanggal_lahir = $data['tanggal_lahir'];
        $this->alamat = $data['alamat'];
        $this->is_active = $data['is_active'];
        $this->password = $data['password'];
    }

    public function GetData()
    {
        return [
            'nama' => $this->nama,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'is_active' => $this->is_active,
            'password' => $this->password,
        ];
    }
    
}

