<?php

function Test($result, $expected){
    if ($result == $expected) {
        echo "Test Passed".PHP_EOL;
    } else {
        echo "Test Failed".PHP_EOL;
        echo "Expected: ".PHP_EOL;
        print_r($expected);
        echo "Result: ".PHP_EOL;
        print_r($result);
    }
}
function Bilangan($JumlahBilangan, $JumlahKelompok)
{
    $BilanganGenap = array();
    $i = 1;
    $total = floor($JumlahBilangan / $JumlahKelompok);
    while (count($BilanganGenap) < $JumlahBilangan) {
        if ($i % 2 == 0) {
            $BilanganGenap[] = $i;
        }

        $i++;
    }
    $array_chunk = array_chunk($BilanganGenap, $total);
    $array_slice = array_slice($array_chunk, 0, $JumlahKelompok);
    $after_index = array_merge_recursive(array_slice($array_chunk, count($array_slice)));
    if ($JumlahKelompok % 2 != 0) {
        $array_slice[count($array_slice) - 1] = array_merge($array_slice[count($array_slice) - 1], end($after_index));
    }
    return $array_slice;
}

function Bintang($JumlahBaris){
    $result = "";
    for ($i=0; $i < $JumlahBaris; $i++) { 
        $result .= str_repeat("*", ($JumlahBaris-$i)+($JumlahBaris-$i)-1).PHP_EOL;
    }
    return $result;
}

$EXPECTED_FUNC1_A = array(array(2, 4, 6, 8, 10), array(12, 14, 16, 18, 20));
$EXPECTED_FUNC1_B = array(array(2, 4), array(6, 8), array(10, 12, 14));

$EXPECTED_FUNC2_A = "*****" . PHP_EOL . "***" . PHP_EOL . "*" . PHP_EOL;
$EXPECTED_FUNC2_B = "*********" . PHP_EOL . "*******" . PHP_EOL . "*****" . PHP_EOL . "***" . PHP_EOL . "*" . PHP_EOL;

Test(Bilangan(10, 2), $EXPECTED_FUNC1_A);
Test(Bilangan(7, 3), $EXPECTED_FUNC1_B);
Test(Bintang(3), $EXPECTED_FUNC2_A);
Test(Bintang(5), $EXPECTED_FUNC2_B);
