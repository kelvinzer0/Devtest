<?php
require 'dataRoutes.php';
require 'swaggerRoutes.php';

$url = $_SERVER['REQUEST_URI'];
$request = array(
    'url' => $url,
    'method' => $_SERVER['REQUEST_METHOD'],
    'headers' => getallheaders(),
    'body' => file_get_contents('php://input')
);
$uri_parse = UriParse($url);
$parsed_url = $uri_parse['query'];
$path = $parsed_url['path'];
$params = UnsetEmptyArrayValue(explode('/', $path));



if (
    $params[1] == "swagger"
) {
    $swaggerRoutes = new SwaggerRoutes();
    echo $swaggerRoutes->routes($request);
} else if(
    $params[1] == "api"
){
    $dataRoutes = new DataRoutes();
    $result = $dataRoutes->routes($request);
    echo json_encode($result);
}

