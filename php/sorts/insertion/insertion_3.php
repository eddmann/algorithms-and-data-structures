<?php

function insertionSort(array $arr) {
    $len = count($arr);

    for ($i = 1; $i < $len; $i++) {
        $tmp = $arr[$i];
        $j = $i - 1;

        while ($j >= 0 && $tmp < $arr[$j]) {
            $arr[$j+1] = $arr[$j];
            $j--;
        }

        $arr[$j+1] = $tmp;
    }

    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = insertionSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";