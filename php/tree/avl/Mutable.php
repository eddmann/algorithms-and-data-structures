<?php

namespace BinaryTree\AVL\Mutable;

use function \BinaryTree\AVL\Node;
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

    $root->height = height($root);

    return balance($root);
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

    $root->height = height($root);

    return balance($root);
}

function height($root)
{
    return max($root->left->height ?? 0, $root->right->height ?? 0) + 1;
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
    return ($root->left->height ?? 0) - ($root->right->height ?? 0);
}

function rotateLeft($root)
{
    $new = $root->right;
    $tmp = $new->left;

    $new->left = $root;
    $root->right = $tmp;

    $root->height = height($root);
    $new->height = height($new);

    return $new;
}

function rotateRight($root)
{
    $new = $root->left;
    $tmp = $new->right;

    $new->right = $root;
    $root->left = $tmp;

    $root->height = height($root);
    $new->height = height($new);

    return $new;
}
