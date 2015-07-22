<?php

require_once(__DIR__ . '/BinaryTree.php');

$tree = BinaryTree\fromArray([5, 2, 12, -4, -10, 3, 9, 21, 19, 20, 18, 25, 26], '\BinaryTree\Mutable\insert');

echo BinaryTree\render(BinaryTree\Immutable\invert($tree));

BinaryTree\Mutable\invert($tree);

echo BinaryTree\render($tree);
