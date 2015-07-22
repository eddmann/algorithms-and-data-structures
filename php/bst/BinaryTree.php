<?php

namespace BinaryTree;

require_once(__DIR__ . '/Mutable.php');
require_once(__DIR__ . '/Immutable.php');
require_once(__DIR__ . '/Traversal.php');

function Node($value, $left = null, $right = null)
{
    return (object) compact('value', 'left', 'right');
}

function fromArray(array $values)
{
    $tree = null;

    foreach ($values as $value) {
        $tree = Mutable\insert($value, $tree);
    }

    return $tree;
}

function fromArrayRep(array $values)
{
    return Node(
        $values[0],
        isset($values[1]) ? fromArrayRep($values[1]) : null,
        isset($values[2]) ? fromArrayRep($values[2]) : null
    );
}

function render($root, $depth = 0)
{
    if ($root === null) {
        return str_repeat("\t", $depth) . "~\n";
    }

    return
        render($root->right, $depth + 1) .
        str_repeat("\t", $depth) . $root->value . "\n" .
        render($root->left, $depth + 1);
}

function minValue($root)
{
    if ($root->left === null) {
        return $root->value;
    }

    return minValue($root->left);
}

