<?php

function insertionSort(array $arr, $comparator) {
    if ( ! is_callable($comparator)) return;

    $len = count($arr);

    array_unshift($arr, -1); // add sentinel

    for ($i = 1; $i < $len+1; $i++) {
        $tmp = $arr[$i];
        $j = $i;

        while ($comparator($tmp, $arr[$j-1])) {
            $arr[$j] = $arr[$j-1];
            $j--;
        }

        $arr[$j] = $tmp;
    }

    array_shift($arr); // remove sentinel

    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = insertionSort($arr, function($a, $b) {
    return $a < $b;
});

echo 'After: ' . implode(', ', $arr) . "\n";