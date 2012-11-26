<?php

/**
 * Shell sort implementation using the 'Shell' sequence.
 * 
 * @param  array $arr The array to sort.
 * @return array      The sorted array.
 */
function shellSort(array $arr) {
    $len = count($arr);

    for ($gap = floor($len / 2); $gap > 0; $gap = floor($gap / 2)) {
        for ($i = $gap; $i < $len; $i++) {
            $tmp = $arr[$i];
            $j = 0;

            // insertion sort
            for ($j = $i; $j >= $gap && $arr[$j-$gap] > $tmp; $j -= $gap) {
                $arr[$j] = $arr[$j-$gap];
            }

            $arr[$j] = $tmp;
        }
    }
    
    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = shellSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";