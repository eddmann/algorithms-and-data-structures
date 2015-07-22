<?php

namespace BinaryTree\Immutable;

use function \BinaryTree\Node;
use function \BinaryTree\minValue;

function insert($value, $root)
{
    if ($root === null) {
        return Node($value);
    }

    if ($value === $root->value) {
        return $root;
    }

    if ($value > $root->value) {
        return Node($root->value, $root->left, insert($value, $root->right));
    }

    return Node($root->value, insert($value, $root->left), $root->right);
}

function remove($value, $root)
{
    if ($root === null) {
        return $root;
    }

    if ($value > $root->value) {
        return Node($root->value, $root->left, remove($value, $root->right));
    }

    if ($value < $root->value) {
        return Node($root->value, remove($value, $root->left), $root->right);
    }

    if ($root->left === null) {
        return $root->right;
    }

    if ($root->right === null) {
        return $root->left;
    }

    $value = minValue($root->right);

    return Node($value, $root->left, remove($value, $root->right));
}

function invert($root)
{
    if ($root === null) {
        return $root;
    }

    return Node($root->value, invert($root->right), invert($root->left));
}
