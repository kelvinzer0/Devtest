<?php

function UnsetEmptyArrayValue($data)
{
    return array_filter($data, function ($value) {
        return $value !== '';
    });
}