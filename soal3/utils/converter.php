<?php

if (!function_exists('setIfUnset')) {
    function setIfUnset($data)
    {
        if (isset($data)) {
            return $data;
        } else {
            return "";
        }
    }
}
