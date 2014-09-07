<?php

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
        $keyLen = strlen($key);
        $nodeKeyLen = strlen($this->key);
        $maxPrefixLen = $this->maxKeyPrefixLength($key);

        $remainingKey = substr($key, $maxPrefixLen);
        $remainingNodeKey = substr($this->key, $maxPrefixLen);

        if ($exactMatch = $keyLen === $maxPrefixLen && $nodeKeyLen === $maxPrefixLen) {
            $this->value = $value;
            $this->isValue = true;
        }

        else if ($maxPrefixLen === 0 || $keyLargerThanNodeKey = $maxPrefixLen < $keyLen && $maxPrefixLen >= $nodeKeyLen) {
            foreach ($this->children as $child) {
                if ($child->key[0] === $remainingKey[0]) {
                    return $child->insert($remainingKey, $value);
                }
            }

            $this->children[] = Node::createWithValue($remainingKey, $value);
        }

        else if ($shareKeyPrefixSplit = $maxPrefixLen < $nodeKeyLen) {
            $this->key = substr($this->key, 0, $maxPrefixLen);
            $this->children = [ Node::createWithValue($remainingNodeKey, $this->value) ];

            if ($maxPrefixLen === $keyLen) {
                $this->value = $value;
                $this->isValue = true;
            } else {
                $this->children[] = Node::createWithValue($remainingKey, $value);
                $this->value = null;
                $this->isValue = false;
            }
        }

        else {
            $this->children[] = Node::createWithValue($remainingKey, $value);
        }
    }

    private function maxKeyPrefixLength($str)
    {
        $len = 0;

        for ($i = 0; $i < min(strlen($this->key), strlen($str)); $i++) {
            if ($this->key[$i] != $str[$i]) break;
            $len++;
        }

        return $len;
    }

    private static function createWithValue($key, $value)
    {
        $n = new self($key);
        $n->value = $value;
        $n->isValue = true;
        return $n;
    }

    public function remove($key)
    {
        foreach ($this->children as $i => $child) {
            $keyLen = strlen($key);
            $nodeLen = strlen($child->key);
            $maxPrefixLen = $child->maxKeyPrefixLength($key);

            if ($exactMatch = $keyLen === $maxPrefixLen && $nodeLen === $maxPrefixLen) {
                if (count($child->children) === 0) {
                    unset($this->children[$i]);
                    return;
                }

                else if ($child->isValue) {
                    $child->value = null;
                    $child->isValue = false;

                    if (count($child->children) === 1) {
                        $subChild = $child->children[0];

                        $child->key = $child->key . $subChild->key;
                        $child->value = $subChild->value;
                        $child->isValue = $subChild->isValue;
                        $child->children = [];
                    }

                    return;
                }
            }

            else if ($traverseChildNode = $maxPrefixLen > 0 && $maxPrefixLen < $keyLen) {
                return $this->remove(substr($key, $maxPrefixLen));
            }
        }
    }

    public function getValue($key)
    {
        if ($node = $this->get($key)) {
            return $node->value;
        }

        throw new Exception;
    }

    private function get($key, $currentKey = '')
    {
        if ($this->isValue && $key === $currentKey) {
            return $this;
        }

        $keyLen = strlen($key);
        $currentKeyLen = strlen($currentKey);

        foreach ($this->children as $child) {
            $newPrefix = $currentKey . $child->key;
            $newPrefixLen = strlen($newPrefix);

            if ($keyLen <= $currentKeyLen ||
                $newPrefixLen <= $currentKeyLen ||
                $newPrefix[$currentKeyLen] === $key[$currentKeyLen]
            ) {
                return $child->get($key, $newPrefix);
            }
        }
    }

    public function count()
    {
        return array_reduce(
            $this->children,
            function($acc, Node $n) { return $acc + count($n); },
            $this->isValue ? 1 : 0
        );
    }
}

class RadixTrie implements \Countable
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

    public function get($key)
    {
        return $this->root->getValue($key);
    }

    public function count()
    {
        return count($this->root);
    }
}
