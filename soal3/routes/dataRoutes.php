<?php
// error_reporting(0);
require_once 'controllers/DataController.php';
require 'models/CreateDataModel.php';
require 'models/UpdateDataModel.php';
require 'utils/converter.php';
require 'utils/uri_parse.php';
require 'utils/clean.php';

class DataRoutes
{
    private $dataController;
    public function __construct()
    {
        $this->dataController = new DataController();
    }
    public function routes($request)
    {
        $url = $request['url'];
        $uri_parse = UriParse($url);
        $query_params = $uri_parse['params'];
        $parsed_url = $uri_parse['query'];
        $headers = $request['headers'];
        $body = $request['body'];
        $path = $parsed_url['path'];
        $query = $query_params;
        $params = UnsetEmptyArrayValue(explode('/', $path));
        $method = $request['method'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
            $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
            if ($content_type !== 'application/json') {
                header('HTTP/1.1 415 Unsupported Media Type');
                echo json_encode(['error' => 'Unsupported Media Type']);
                exit;
            }
        }
        
        if (
            $params[1] == "api"
            && $params[2] == "users"
            && !isset($params[3])
            && $method == 'GET'
        ) {
            $limit = isset($query['limit']) ? $query['limit'] : 10;
            $page = isset($query['page']) ? $query['page'] : 1;
            $deleted = isset($query['deleted']) ? $query['deleted'] : false;
            $result = $this->dataController->GetAll($limit, $page, $deleted);
        } else if (
            $params[1] == "api"
            && $params[2] == "users"
            && isset($params[3])
            && $method == 'GET'
        ) {
            $result = $this->dataController->GetOne($params[3]);
        } else if (
            $params[1] == "api"
            && $params[2] == "users"
            && (!isset($params[3]) || $params[3] != "")
            && $method == 'POST'
        ) {
            $data = json_decode($body, true);
            $createModel = new CreateDataModel($data);
            $result = $this->dataController->Create($createModel->GetData());

        } else if (
            count($params) == 3
            && $params[1] == "api"
            && $params[2] == "users"
            && $params[3] != ""
            && $method == 'PUT'
        ) {
            $data = json_decode($body, true);
            $data['id'] = $params[3];
            $updateModel = new UpdateDataModel($data);
            $result = $this->dataController->Update($params[3], $updateModel->GetData());
        } else if (
            $params[1] == "api"
            && $params[2] == "users"
            && isset($params[3])
            && $method == 'DELETE'
        ) {
            $result = $this->dataController->Delete($params[3], $query['soft_delete']);
        }else {
            $result = array(
                'code' => 404,
                'message' => 'Not Found'
            );
        }
        return $result;
    }
}
