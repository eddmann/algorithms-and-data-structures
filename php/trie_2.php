<?php

function head($str)
{
    return substr($str, 0, 1);
}

function tail($str)
{
    return substr($str, 1);
}

class Node implements \Countable
{
    private $key;
    private $value = null;
    private $isValue = false;
    private $children = [];

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function insert($key, $value)
    {
        if ($head = head($key)) {
            $node = $this->child($head) ?: $this->children[] = new self($head);

            if ($tail = tail($key)) {
                $node->insert($tail, $value);
            } else {
                $node->value = $value;
                $node->isValue = true;
            }
        }
    }

    private function &child($key)
    {
        $node = null;

        foreach ($this->children as $child) {
            if ($child->key === $key) {
                $node = $child;
                break;
            }
        }

        return $node;
    }

    public function remove($key)
    {
        if ($node = $this->child(head($key))) {
            if ($tail = tail($key)) {
                $node->remove($tail);
            } else {
                $node->value = null;
                $node->isValue = false;
            }

            if (count($node) === 0) {
                unset($node); // todo
            }
        }
    }

    public function getNode($key)
    {
        if ($node = $this->child(head($key))) {
            return ($tail = tail($key))
                ? $node->getNode($tail)
                : $node;
        }

        throw new \InvalidArgumentException;
    }

    public function getValue($key)
    {
        if (($node = $this->getNode($key)) && $node->isValue) {
            return $node->value;
        }

        throw new \InvalidArgumentException;
    }

    public function keys($prefix)
    {
        $result = $this->isValue
            ? array($prefix)
            : array();

        foreach ($this->children as $child) {
            $result = array_merge($result, $child->keys($prefix . $child->key));
        }

        return $result;
    }

    public function count()
    {
        return array_reduce(
            $this->children,
            function ($acc, Node $n) { return $acc + count($n); },
            $this->isValue ? 1: 0
        );
    }
}

class Trie implements \Countable
{
    private $root;

    public function __construct()
    {
        $this->root = new Node(null);
    }

    public function insert($key, $value)
    {
        $this->root->insert($key, $value);
    }

    public function remove($key)
    {
        $this->root->remove($key);
    }

    public function count()
    {
        return count($this->root);
    }

    public function keys($prefix = null)
    {
        $start = $prefix
            ? $this->root->getNode($prefix)
            : $this->root;

        return $start->keys($prefix);
    }

    public function get($key)
    {
        return $this->root->getValue($key);
    }
}
