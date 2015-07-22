<?php

namespace BinaryTree\AVL;

require_once(__DIR__ . '/../BinaryTree.php');
require_once(__DIR__ . '/Mutable.php');

function Node($value, $height = 1, $left = null, $right = null)
{
    return (object) compact('value', 'height', 'left', 'right');
}

$tree = \BinaryTree\fromArray([1, 6, 2, 7, 3, 8, 4, 9, 5], '\BinaryTree\AVL\Mutable\insert');

$tree = \BinaryTree\AVL\Mutable\remove(9, $tree);
$tree = \BinaryTree\AVL\Mutable\remove(8, $tree);

echo \BinaryTree\render($tree);
