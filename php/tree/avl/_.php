<?php

namespace BinaryTree\AVL;

require_once(__DIR__ . '/../BinaryTree.php');
require_once(__DIR__ . '/Mutable.php');
require_once(__DIR__ . '/Immutable.php');

$tree = \BinaryTree\fromArray([1, 10, 2, 9, 3, 8, 4, 7, 5], '\BinaryTree\AVL\Immutable\insert');

$tree = \BinaryTree\AVL\Immutable\remove(10, $tree);
$tree = \BinaryTree\AVL\Immutable\remove(9, $tree);

echo \BinaryTree\render($tree);
