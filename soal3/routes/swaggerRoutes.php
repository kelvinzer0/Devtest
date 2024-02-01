<?php

class SwaggerRoutes {
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

        if (
            !isset($params[2])
            && $method == 'GET'
        ) {
            return file_get_contents("doc/swagger.html");
        } else if (
            $params[2] == 'config.yaml'
        ) {
            return file_get_contents("doc/config.yaml");
        } else {
            return "404 Not Found";
        }
    }
}