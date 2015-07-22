<?php

require_once(__DIR__ . '/BinaryTree.php');

use function \BinaryTree\minValue;
use function \BinaryTree\render;

function Node($value, $height = 1, $left = null, $right = null)
{
    return (object) compact('value', 'height', 'left', 'right');
}

function insert($value, $root)
{
    if ($root === null) {
        return Node($value);
    }

    if ($value === $root->value) {
        return $root;
    }

    if ($value > $root->value) {
        $root->right = insert($value, $root->right);
    } else {
        $root->left = insert($value, $root->left);
    }

    $root->height = heightFrom($root);

    return balance($root);
}

function heightFrom($root)
{
    return max(height($root->left), height($root->right)) + 1;
}

function height($node)
{
    return $node === null ? 0 : $node->height;
}

function balance($root)
{
    if ($isLeft = factor($root) > 1) {
        if ($isDouble = factor($root->left) < 0) {
            $root->left = rotateLeft($root->left);
        }

        return rotateRight($root);
    }

    if ($isRight = factor($root) < -1) {
        if ($isDouble = factor($root->right) > 0) {
            $root->right = rotateRight($root->right);
        }

        return rotateLeft($root);
    }

    return $root;
}

function factor($root)
{
    return height($root->left) - height($root->right);
}

function rotateLeft($root)
{
    $new = $root->right;
    $tmp = $new->left;

    $new->left = $root;
    $root->right = $tmp;

    $root->height = heightFrom($root);
    $new->height = heightFrom($new);

    return $new;
}

function rotateRight($root)
{
    $new = $root->left;
    $tmp = $new->right;

    $new->right = $root;
    $root->left = $tmp;

    $root->height = heightFrom($root);
    $new->height = heightFrom($new);

    return $new;
}

function remove($value, $root)
{
    if ($root === null) {
        return $root;
    }

    if ($value > $root->value) {
        $root->right = remove($value, $root->right);
    }

    else if ($value < $root->value) {
        $root->left = remove($value, $root->left);
    }

    else if ($root->right === null) {
        $root = $root->left;
    }

    else if ($root->left === null) {
        $root = $root->right;
    }

    else {
        $root->value = minValue($root->right);
        $root->right = remove($root->value, $root->right);
    }

    if ($root === null) {
        return $root;
    }

    $root->height = heightFrom($root);

    return balance($root);
}

function fromArray(array $values)
{
    $tree = null;

    foreach ($values as $value) {
        $tree = insert($value, $tree);
    }

    return $tree;
}

$tree = fromArray([1, 6, 2, 7, 3, 8, 4, 9, 5]);

$tree = remove(9, $tree);
$tree = remove(8, $tree);

echo render($tree);
