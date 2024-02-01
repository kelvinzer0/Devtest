<?php
require 'usecase/DataUsecase.php';
require 'models/DataModel.php';
require 'models/SuccessDataModel.php';
require 'models/ErrorDataModel.php';
class DataController
{
    private $dataUsecase;
    public function __construct()
    {
        $this->dataUsecase = new DataUsecase();
    }
    public function GetAll($limit, $page = 1, $deleted = false)
    {
        $data = $this->dataUsecase->GetAll($limit, $page, $deleted);
        $dataModels = array();
        foreach ($data as $row) {
            $dataModel = new DataModel($row);
            array_push($dataModels, $dataModel);
        }
        $result = array(
            'code' => 200,
            'type' => 'GET_ALL_DATA',
            'message' => 'Success get all data',
            'data' => $dataModels
        );
        http_response_code(200);
        $successDataModel = new SuccessDataModel($result);
        return $successDataModel;
    }

    public function GetOne($id)
    {
        $data = $this->dataUsecase->GetOne($id);
        if ($data == null) {
            $result = array(
                'code' => 404,
                'type' => 'GET_DATA',
                'message' => 'Failed get data',
            );
            http_response_code(404);
            $errorDataModel = new ErrorDataModel($result);
            return $errorDataModel;
        }
        $result = array(
            'code' => 200,
            'type' => 'GET_DATA',
            'message' => 'Success get data',
            'data' => new DataModel($data)
        );
        http_response_code(200);
        $successDataModel = new SuccessDataModel($result);
        return $successDataModel;
    }

    public function Create($data)
    {
        $data = $this->dataUsecase->Create($data);
        $result = array(
            'code' => 200,
            'type' => 'CREATE_DATA',
            'message' => 'Success create data',
            'data' => new DataModel($data)
        );
        http_response_code(200);
        $successDataModel = new SuccessDataModel($result);
        return $successDataModel;
    }

    public function Update($id, $data)
    {
        $result = $this->dataUsecase->Update($id, $data);
        if ($result == null) {
            $result = array(
                'code' => 404,
                'type' => 'GET_DATA',
                'message' => 'Failed get data',
            );
            http_response_code(404);
            $errorDataModel = new ErrorDataModel($result);
            return $errorDataModel;
        }
        if ($result) {
            $result = array(
                'code' => 200,
                'type' => 'UPDATE_DATA',
                'message' => 'Success update data',
                'data' => new DataModel($data)
            );
            http_response_code(200);
            $successDataModel = new SuccessDataModel($result);
            return $successDataModel;
        } else {
            $result = array(
                'code' => 400,
                'type' => 'UPDATE_DATA',
                'message' => 'Failed update data',
            );
            http_response_code(404);
            $failedDataModel = new ErrorDataModel($result);
            return $failedDataModel;
        }
    }

    public function Delete($id, $soft_delete = true)
    {
        $data = $this->dataUsecase->Delete($id, $soft_delete);
        if ($data == null) {
            $result = array(
                'code' => 404,
                'type' => 'DELETE_DATA',
                'message' => 'Failed get data',
            );
            http_response_code(404);
            $errorDataModel = new ErrorDataModel($result);
            return $errorDataModel;
        } else {
            $result = array(
                'code' => 200,
                'type' => 'DELETE_DATA',
                'message' => 'Success delete data',
                'data' => null
            );
            http_response_code(200);
            $successDataModel = new SuccessDataModel($result);
            return $successDataModel;
        }

    }
}