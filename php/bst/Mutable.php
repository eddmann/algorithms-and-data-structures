<?php

namespace BinaryTree\Mutable;

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
        $root->right = insert($value, $root->right);
    } else {
        $root->left = insert($value, $root->left);
    }

    return $root;
}

function remove($value, $root)
{
    if ($root === null) {
        return $root;
    }

    if ($value > $root->value) {
        $root->right = remove($value, $root->right);

        return $root;
    }

    if ($value < $root->value) {
        $root->left = remove($value, $root->left);

        return $root;
    }

    if ($root->right === null) {
        return $root->left;
    }

    if ($root->left === null) {
        return $root->right;
    }

    $value = minValue($root->right);

    $root->right = remove($value, $root->right);

    $root->value = $value;

    return $root;
}

function invert($root)
{
    if ($root === null) {
        return $root;
    }

    $tmp = $root->left;
    $root->left = invert($root->right);
    $root->right = invert($tmp);

    return $root;
}
