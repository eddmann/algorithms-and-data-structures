<?php

/**
 * Shell sort implementation using the 'Sedgewick and Incerpi' sequence.
 * 
 * @param  array $arr The array to sort.
 * @return array      The sorted array.
 */
function shellSort(array $arr) {
    $len = count($arr);

    $gap = 1;
    while ($gap < floor($len / 3)) {
        $gap = floor(3 * $gap + 1);
    }
    
    while ($gap > 0) {
        for ($i = $gap; $i < $len; $i++) {
            for ($j = $i; $j >= $gap && ( $arr[$j] < $arr[$j-$gap] ); $j -= $gap) {
                $tmp          = $arr[$j];
                $arr[$j]      = $arr[$j-$gap];
                $arr[$j-$gap] = $tmp;
            }
        }

        $gap = (floor($gap / 3));
    }
    
    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = shellSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";