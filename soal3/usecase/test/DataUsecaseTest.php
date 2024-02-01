<?php

require 'vendor/autoload.php';
require 'usecase/DataUsecase.php';

use PHPUnit\Framework\TestCase;

class DataUsecaseTest extends TestCase
{
    private $dataUsecase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dataUsecase = new DataUsecase();
        $this->_createdID = 2;
    }

    public function testCreate(){
        
        $data = $this->dataUsecase->Create(array(
            'nama' => 'Asep',
            'tanggal_lahir' => '1999-01-01',
            'alamat' => 'Jl. Testing',
            'password_hash' => password_hash("Test", PASSWORD_BCRYPT),
            'password_algorithm' => 'BCRYPT',
            'is_active' => true,
        ));

        $this->assertNotEmpty($data);
    }

    public function testGetAll()
    {
        $data = $this->dataUsecase->GetAll(10, 1, false);
        $this->assertNotEmpty($data);
    }

    public function testGetOne()
    {
        $id = $this->dataUsecase->LastInsert()->fetch_assoc()['id'];
        $data = $this->dataUsecase->GetOne($id);
        $this->assertNotEmpty($data);
    }

    public function testUpdate(){
        $id = $this->dataUsecase->LastInsert()->fetch_assoc()['id'];
        $data = $this->dataUsecase->Update($id, array(
            'nama' => 'Asep',
            'tanggal_lahir' => '1999-01-01',
            'alamat' => 'Jl. Testing Update',
            'password_hash' => password_hash("x123", PASSWORD_BCRYPT),
            'password_algorithm' => 'BCRYPT',
            'is_active' => true,
        ));
        $this->assertNotEmpty($data);
    }

    public function testSoftDelete(){
        $data = $this->dataUsecase->Delete($this->dataUsecase->LastInsert()->fetch_assoc()['id']);
        $this->assertNotEmpty($data);
    }
    public function testHardDelete()
    {
        $data = $this->dataUsecase->Delete($this->dataUsecase->LastInsert()->fetch_assoc()['id'], false);
        $this->assertNotEmpty($data);
    }
}
