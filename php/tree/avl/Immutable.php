<?php

namespace BinaryTree\AVL\Immutable;

use function \BinaryTree\minValue;

function Node($value, $left = null, $right = null)
{
    $height = max($left->height ?? 0, $right->height ?? 0) + 1;

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
        return balance(Node($root->value, $root->left, insert($value, $root->right)));
    }

    return balance(Node($root->value, insert($value, $root->left), $root->right));
}

function remove($value, $root)
{
    if ($root === null) {
        return $root;
    }

    if ($value > $root->value) {
        $root = Node($root->value, $root->left, remove($value, $root->right));
    }

    else if ($value < $root->value) {
        $root = Node($root->value, remove($value, $root->left), $root->right);
    }

    else if ($root->right === null) {
        $root = $root->right;
    }

    else if ($root->left === null) {
        $root = $root->left;
    }

    else {
        $value = minValue($root->right);
        $root = Node($value, $root->left, remove($value, $root->right));
    }

    return balance($root);
}

function balance($root)
{
    if ($root === null) {
        return $root;
    }

    if ($isLeft = factor($root) > 1) {
        if ($isDouble = factor($root->left) < -1) {
            $root = Node($root->value, rotateLeft($root->left), $root->right);
        }

        return rotateRight($root);
    }

    if ($isRight = factor($root) < -1) {
        if ($isDouble = factor($root->right) > 1) {
            $root = Node($root->value, $root->left, rotateRight($root->right));
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
    if ($root->right === null) {
        return $root;
    }

    return Node(
        $root->right->value,
        Node($root->value, $root->left, $root->right->left),
        $root->right->right
    );
}

function rotateRight($root)
{
    if ($root->left === null) {
        return $root;
    }

    return Node(
        $root->left->value,
        $root->left->left,
        Node($root->value, $root->left->right, $root->right)
    );
}
