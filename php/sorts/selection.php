<?php

function selectionSort(array $arr) {
    $len = count($arr);

    for ($i = 0; $i < $len; $i++) {
        $min = $i;

        for ($j = $i+1; $j < $len; $j++) {
            if ($arr[$j] < $arr[$min]) {
                $min = $j;
            }
        }

        $tmp       = $arr[$i];
        $arr[$i]   = $arr[$min];
        $arr[$min] = $tmp;
    }

    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = selectionSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";