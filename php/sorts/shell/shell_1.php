<?php

/**
 * Shell sort implementation using the 'Shell' sequence.
 * 
 * @param  array $arr The array to sort.
 * @return array      The sorted array.
 */
function shellSort(array $arr) {
    $len = count($arr);

    $gap = floor($len / 2);

    while ($gap > 0) {
        for ($i = $gap; $i < $len; $i++) {
            $tmp = $arr[$i];
            $j = $i;

            // insertion sort
            while ($j >= $gap && ( $arr[$j-$gap] > $tmp )) {
                $arr[$j] = $arr[$j-$gap];
                $j -= $gap;
            }

            $arr[$j] = $tmp;
        }

        $gap = floor($gap / 2);
    }

    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = shellSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";