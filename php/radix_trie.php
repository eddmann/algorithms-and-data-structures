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
        list($keyLen, $nodeKeyLen, $maxPrefixLen) = $this->keyLengths($key);

        $remainingKey = substr($key, $maxPrefixLen);
        $remainingNodeKey = substr($this->key, $maxPrefixLen);

        if ($this->isExactMatch($keyLen, $nodeKeyLen, $maxPrefixLen)) {
            $this->setValue($value);
        }
        else if ($this->isNoMatch($maxPrefixLen) || $this->isNodeKeyPrefix($keyLen, $nodeKeyLen, $maxPrefixLen)) {
            foreach ($this->children as $child) {
                if ($child->key[0] === $remainingKey[0]) {
                    $child->insert($remainingKey, $value);
                    return;
                }
            }

            $this->addChildNode($remainingKey, $value);
        }
        else if ($this->isSharedKeyPrefix($nodeKeyLen, $maxPrefixLen)) {
            $this->key = substr($this->key, 0, $maxPrefixLen);
            $this->children = [];
            $this->addChildNode($remainingNodeKey, $this->value);

            if ($maxPrefixLen === $keyLen) {
                $this->setValue($value);
            } else {
                $this->clearValue();
                $this->addChildNode($remainingKey, $value);
            }
        }
    }

    private function keyLengths($key)
    {
        $maxPrefixLen = function() use($key) {
            $l = 0;
            for ($i = 0; $i < min(strlen($this->key), strlen($key)); $i++) {
                if ($this->key[$i] != $key[$i]) break;
                $l++;
            }
            return $l;
        };

        return [ strlen($key), strlen($this->key), $maxPrefixLen() ];
    }

    private function isExactMatch($keyLen, $nodeKeyLen, $maxPrefixLen)
    {
        return $keyLen === $maxPrefixLen && $nodeKeyLen === $maxPrefixLen;
    }

    private function setValue($value)
    {
        $this->value = $value;
        $this->isValue = true;
    }

    private function isNoMatch($maxPrefixLen)
    {
        return $maxPrefixLen === 0;
    }

    private function isNodeKeyPrefix($keyLen, $nodeKeyLen, $maxPrefixLen)
    {
        return $maxPrefixLen >= $nodeKeyLen && $maxPrefixLen < $keyLen;
    }

    private function addChildNode($key, $value)
    {
        $child = new self($key);
        $child->setValue($value);
        $this->children[] = $child;
    }

    private function isSharedKeyPrefix($nodeKeyLen, $maxPrefixLen)
    {
        return $maxPrefixLen < $nodeKeyLen;
    }

    private function clearValue()
    {
        $this->value = null;
        $this->isValue = false;
    }

    public function remove($key)
    {
        foreach ($this->children as $i => $child) {
            list($keyLen, $nodeKeyLen, $maxPrefixLen) = $this->keyLengths($key);

            $isExactMatch = $this->isExactMatch($keyLen, $nodeKeyLen, $maxPrefixLen);

            if ($isExactMatch && count($child->children) === 0) {
                unset($this->children[$i]);
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
                $this->remove(substr($key, $maxPrefixLen));
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

    public function getValue($key, $acc = '')
    {
        if ($this->isValue && $key === $acc) {
            return $this->value;
        }

        foreach ($this->children as $child) {
            $newPrefix = $acc . $child->key;

            if ($this->isPossibleMatch($key, $acc, $newPrefix)) {
                return $child->getValue($key, $newPrefix);
            }
        }
    }

    private function isPossibleMatch($key, $acc, $newPrefix)
    {
        return
            strlen($key) <= ($l = strlen($acc)) ||
            strlen($newPrefix) <= $l ||
            $newPrefix[$l] === $key[$l];
    }

    public function keys($prefix = '', $acc = '')
    {
        $keys = $this->isKeyPrefixWithValue($prefix, $acc)
            ? [ $acc ]
            : [];

        foreach ($this->children as $child) {
            $newPrefix = $acc . $child->key;

            if ($this->isPossibleMatch($prefix, $acc, $newPrefix)) {
                $keys = array_merge($keys, $child->keys($prefix, $newPrefix));
            }
        }

        return $keys;
    }

    private function isKeyPrefixWithValue($prefix, $acc)
    {
        return $this->isValue && ($prefix === '' || strpos($acc, $prefix) === 0);
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

    public function keys($prefix = '')
    {
        return $this->root->keys($prefix);
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
