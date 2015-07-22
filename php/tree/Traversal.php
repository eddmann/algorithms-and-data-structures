<?php

namespace BinaryTree\Traversal;

function pre_order($root)
{
    if ($root === null) {
        return;
    }

    yield $root->value;
    foreach (pre_order($root->left) as $value) yield $value;
    foreach (pre_order($root->right) as $value) yield $value;
}

function in_order($root)
{
    if ($root === null) {
        return;
    }

    foreach (in_order($root->left) as $value) yield $value;
    yield $root->value;
    foreach (in_order($root->right) as $value) yield $value;
}

function post_order($root)
{
    if ($root === null) {
        return;
    }

    foreach (post_order($root->left) as $value) yield $value;
    foreach (post_order($root->right) as $value) yield $value;
    yield $root->value;
}

function level_order($root)
{
    $q = [$root];

    while ($q) {
        $n = array_shift($q);
        yield $n->value;
        if ($n->left) $q[] = $n->left;
        if ($n->right) $q[] = $n->right;
    }
}

// http://rosettacode.org/wiki/Tree_traversal#Python:_Class_based
// http://algoviz.org/OpenDSA/Books/OpenDSA/html/CompleteTree.html
// http://webdocs.cs.ualberta.ca/~holte/T26/tree-as-array.html
