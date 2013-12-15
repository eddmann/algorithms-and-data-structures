<?php

function rpn($s)
{
    return (double) array_reduce(explode(' ', $s), function($a, $b)
    {
        array_push($a, doubleval($b)
            ? $b
            : call_user_func(function() use (&$a, &$b) {
                ob_start();
                $t = array_pop($a);
                eval('echo ' . array_pop($a) . $b . $t  . ';');
                return ob_get_clean();
            })
        );
        return $a;
    }, [])[0];
}

var_dump(rpn('4 2 * 8 + 2 /'));