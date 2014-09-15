<?php

class Node
{
    public $key;
    public $value = null;
    public $isValue = false;
    public $children = [];

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function setValue($value)
    {
        $this->value = $value;
        $this->isValue = true;
    }

    public function clearValue()
    {
        $this->value = null;
        $this->isValue = false;
    }

    public function addChildNode($key, $value)
    {
        $child = new self($key);
        $child->setValue($value);
        $this->children[] = $child;
    }
}

class RadixTrie implements \Countable
{
    private $root;

    public function __construct()
    {
        $this->root = new Node(null);
    }

    public function insert($key, $value, Node $node = null)
    {
        $node = $this->nodeOrRoot($node);

        list($keyLen, $nodeKeyLen, $maxPrefixLen) = $this->calcKeyLengths($key, $node);

        $remainingKey = substr($key, $maxPrefixLen);
        $remainingNodeKey = substr($node->key, $maxPrefixLen);

        if ($this->isExactMatch($keyLen, $nodeKeyLen, $maxPrefixLen)) {
            $node->setValue($value);
        }
        else if ($this->isNoMatch($maxPrefixLen) || $this->isNodeKeyPrefix($keyLen, $nodeKeyLen, $maxPrefixLen)) {
            foreach ($node->children as $child) {
                if ($child->key[0] === $remainingKey[0]) {
                    $this->insert($remainingKey, $value, $child);
                    return;
                }
            }

            $node->addChildNode($remainingKey, $value);
        }
        else if ($this->isSharedKeyPrefix($nodeKeyLen, $maxPrefixLen)) {
            $node->key = substr($node->key, 0, $maxPrefixLen);
            $node->children = [];
            $node->addChildNode($remainingNodeKey, $node->value);

            if ($maxPrefixLen === $keyLen) {
                $node->setValue($value);
            } else {
                $node->clearValue();
                $node->addChildNode($remainingKey, $value);
            }
        }
    }

    private function nodeOrRoot($node)
    {
        return $node ?: $this->root;
    }

    private function calcKeyLengths($key, Node $node)
    {
        $keyLen = strlen($key);
        $nodeKeyLen = strlen($node->key);

        $maxPrefixLen = 0;
        for ($i = 0; $i < min($keyLen, $nodeKeyLen); $i++) {
            if ($key[$i] != $node->key[$i]) break;
            $maxPrefixLen++;
        }

        return [ $keyLen, $nodeKeyLen, $maxPrefixLen ];
    }

    private function isExactMatch($keyLen, $nodeKeyLen, $maxPrefixLen)
    {
        return $keyLen === $maxPrefixLen && $nodeKeyLen === $maxPrefixLen;
    }

    private function isNoMatch($maxPrefixLen)
    {
        return $maxPrefixLen === 0;
    }

    private function isNodeKeyPrefix($keyLen, $nodeKeyLen, $maxPrefixLen)
    {
        return $maxPrefixLen >= $nodeKeyLen && $maxPrefixLen < $keyLen;
    }

    private function isSharedKeyPrefix($nodeKeyLen, $maxPrefixLen)
    {
        return $maxPrefixLen < $nodeKeyLen;
    }

    public function remove($key, Node $node = null)
    {
        $node = $this->nodeOrRoot($node);

        foreach ($node->children as $i => $child) {
            list($keyLen, $nodeKeyLen, $maxPrefixLen) = $this->calcKeyLengths($key, $child);

            $isExactMatch = $this->isExactMatch($keyLen, $nodeKeyLen, $maxPrefixLen);

            if ($isExactMatch && count($child->children) === 0) {
                unset($node->children[$i]);
                break;
            }
            else if ($isExactMatch && $child->isValue) {
                $child->clearValue();

                if (count($child->children) === 1) {
                    $this->mergeParentAndChildNode($child);
                }

                break;
            }
            else if ($this->isKeyPrefix($keyLen, $maxPrefixLen)) {
                $this->remove(substr($key, $maxPrefixLen), $child);
                break;
            }
        }
    }

    private function mergeParentAndChildNode(Node $p)
    {
        $c = $p->children[0];
        $p->key .= $c->key;
        $p->value = $c->value;
        $p->isValue = $c->isValue;
        $p->children = [];
    }

    private function isKeyPrefix($keyLen, $maxPrefixLen)
    {
        return $maxPrefixLen > 0 && $maxPrefixLen < $keyLen;
    }

    public function get($key, $acc = '', Node $node = null)
    {
        $node = $this->nodeOrRoot($node);

        if ($node->isValue && $key === $acc) {
            return $node->value;
        }

        foreach ($node->children as $child) {
            $newPrefix = $acc . $child->key;

            if ($this->isPossibleMatch($key, $acc, $newPrefix)) {
                return $this->get($key, $newPrefix, $child);
            }
        }

        throw new OutOfBoundsException("Key '$key' does not exist.");
    }

    private function isPossibleMatch($key, $acc, $newPrefix)
    {
        return
            strlen($key) <= ($l = strlen($acc)) ||
            strlen($newPrefix) <= $l ||
            $newPrefix[$l] === $key[$l];
    }

    public function keys($prefix = '', $acc = '', Node $node = null)
    {
        $node = $this->nodeOrRoot($node);

        $keys = $this->isKeyPrefixWithValue($node, $prefix, $acc)
            ? [ $acc ]
            : [];

        foreach ($node->children as $child) {
            $newPrefix = $acc . $child->key;

            if ($this->isPossibleMatch($prefix, $acc, $newPrefix)) {
                $keys = array_merge($keys, $this->keys($prefix, $newPrefix, $child));
            }
        }

        return $keys;
    }

    private function isKeyPrefixWithValue(Node $node, $prefix, $acc)
    {
        return $node->isValue && ($prefix === '' || strpos($acc, $prefix) === 0);
    }

    public function count(Node $node = null)
    {
        $node = $this->nodeOrRoot($node);

        return array_reduce(
            $node->children,
            function($acc, Node $n) { return $acc + $this->count($n); },
            $node->isValue ? 1 : 0
        );
    }
}
