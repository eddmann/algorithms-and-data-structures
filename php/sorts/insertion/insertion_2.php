<?php

function insertionSort(array $arr) {
    $len = count($arr);

    for ($i = 1; $i < $len; $i++) {
        $tmp = $arr[$i];
        $j = $i;

        while ($j > 0 && $arr[$j-1] > $tmp) {
            $arr[$j] = $arr[$j-1];
            $j--;
        }

        $arr[$j] = $tmp;
    }

    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = insertionSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";