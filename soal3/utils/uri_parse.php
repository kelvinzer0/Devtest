<?php

function UriParse($url)
{
    $parsed_url = parse_url($url);
    $query_params = [];

    if (isset($parsed_url['query'])) {
        parse_str($parsed_url['query'], $query_params);

        $query_params = array_filter($query_params, function ($value) {
            return $value !== '';
        });
    } else {
        $parsed_url['query'] = '';
    }

    return ['params' => $query_params, 'query' => $parsed_url];
}
