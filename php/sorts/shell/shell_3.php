<?php

/**
 * Shell sort implementation using the 'Pratt' sequence.
 * 
 * @param  array $arr The array to sort.
 * @return array      The sorted array.
 */
function shellSort(array $arr) {
    $len = count($arr);

    // calculate the first 25 pratt numbers
    $gaps = array(1);
    $last2 = $last3 = 0;

    for ($i = 1; $i < 25; $i++) {
        $tmp2 = floor($gaps[$last2] * 2);
        $tmp3 = floor($gaps[$last3] * 3);

        if ($tmp2 < $tmp3) {
            $gaps[] = $tmp2;
            $last2++;
        } else if ($tmp2 > $tmp3) {
            $gaps[] = $tmp3;
            $last3++;
        } else {
            $gaps[] = $tmp2;
            $last2++;
            $last3++;
        }
    }
    
    $gap = array_pop($gaps);

    while ($gap > 0) {
        for ($i = $gap; $i < $len; $i++) {
            $tmp = $arr[$i];
            $j = $i;

            while ($j >= $gap && ( $arr[$j-$gap] > $tmp )) {
                $arr[$j] = $arr[$j-$gap];
                $j -= $gap;
            }

            $arr[$j] = $tmp;
        }

        $gap = array_pop($gaps);
    }

    return $arr;
}

$arr = range('a', 'z');
shuffle($arr);

echo 'Before: ' . implode(', ', $arr) . "\n";

$arr = shellSort($arr);

echo 'After: ' . implode(', ', $arr) . "\n";