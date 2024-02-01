<?php
require 'repository/DataRepository.php';
class DataUsecase {
    public $dataRepository;
    public function __construct()
    {
        $this->dataRepository = new DataRepository();
    }

    public function GetAll($limit, $page = 1, $deleted = false){
        $offset = ($page - 1) * $limit;
        $data = $this->dataRepository->GetAll($limit, $offset, $deleted);
        return $data;
    }

    public function GetOne($id){
        $data = $this->dataRepository->GetOne($id);
        if ($data->num_rows > 0) {
            $data = $data->fetch_assoc();
        } else {
            $data = null;
        }
        return $data;
    }

    public function Create($data){
        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['password_algorithm'] = "BCRYPT";
        unset($data['password']);
        $data = $this->dataRepository->Create($data);
        return $data;
    }
    public function Update($id, $data){
        if (!$this->GetOne($id)) {
            return null;
        }
        $data['id'] = $id;
        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['password_algorithm'] = "BCRYPT";
        unset($data['password']);
        $data = $this->dataRepository->Update($data);
        return $data;
    }
    public function Delete($id, $soft_delete = true){
        if(!$this->GetOne($id)){
            return ;
        }
        $data = $this->dataRepository->Delete($id, $soft_delete);
        return $data;
    }

    public function LastInsert(){
        $data = $this->dataRepository->LastInsert();
        return $data;
    }
}