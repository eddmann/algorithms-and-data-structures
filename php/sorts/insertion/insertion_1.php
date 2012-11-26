<?php

function insertionSort(array $arr) {
    $len = count($arr);

    for ($i = 0; $i < $len; $i++) {
        for ($j = $i; $j > 0 && ($arr[$j] < $arr[$j-1]); $j--) {
            $tmp       = $arr[$j];
            $arr[$j]   = $arr[$j-1];
            $arr[$j-1] = $tmp;
        }
    }

    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = insertionSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";