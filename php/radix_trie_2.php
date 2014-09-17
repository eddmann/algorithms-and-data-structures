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

    public function insert($key, $value)
    {
        $this->insertFromNode($key, $value, $this->root);
    }

    private function insertFromNode($key, $value, Node $node)
    {
        list($keyLen, $nodeKeyLen, $maxPrefixLen) = $this->calcKeyLengths($key, $node);

        $matchedKey = substr($key, 0, $maxPrefixLen);
        $remainingKey = substr($key, $maxPrefixLen);
        $remainingNodeKey = substr($node->key, $maxPrefixLen);

        if ($this->isExactMatch($keyLen, $nodeKeyLen, $maxPrefixLen)) {
            $node->setValue($value);
        }
        else if ($this->isNoMatch($maxPrefixLen) || $this->isNodeKeyPrefix($keyLen, $nodeKeyLen, $maxPrefixLen)) {
            foreach ($node->children as $child) {
                if ($child->key[0] === $remainingKey[0]) {
                    $this->insertFromNode($remainingKey, $value, $child);
                    return;
                }
            }

            $node->addChildNode($remainingKey, $value);
        }
        else if ($this->isSharedKeyPrefix($nodeKeyLen, $maxPrefixLen)) {
            $node->key = $matchedKey;
            $node->children = [ $this->cloneNodeWithKey($node, $remainingNodeKey) ];

            if ($maxPrefixLen === $keyLen) {
                $node->setValue($value);
            } else {
                $node->clearValue();
                $node->addChildNode($remainingKey, $value);
            }
        }
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

    private function cloneNodeWithKey(Node $n, $newKey)
    {
        $c = new Node($newKey);
        $c->value = $n->value;
        $c->isValue = $n->isValue;
        $c->children = $n->children;

        return $c;
    }

    public function remove($key)
    {
        $this->removeFromNode($key, $this->root);
    }

    private function removeFromNode($key, Node $node)
    {
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
                $this->removeFromNode(substr($key, $maxPrefixLen), $child);
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

    public function getValue($key)
    {
        return $this->getValueFromNode($key, '', $this->root);
    }

    private function getValueFromNode($key, $currKey, Node $node)
    {
        if ($node->isValue && $key === $currKey) {
            return $node->value;
        }

        foreach ($node->children as $child) {
            $newPrefix = $currKey . $child->key;

            if ($this->isPossibleMatch($key, $currKey, $newPrefix)) {
                return $this->getValueFromNode($key, $newPrefix, $child);
            }
        }

        throw new OutOfBoundsException("Key '$key' does not exist.");
    }

    private function isPossibleMatch($key, $currKey, $newPrefix)
    {
        return
            strlen($key) <= ($l = strlen($currKey)) ||
            strlen($newPrefix) <= $l ||
            $newPrefix[$l] === $key[$l];
    }

    public function getKeysWithPrefix($prefix)
    {
        return $this->getKeysFromNode($prefix, '', $this->root);
    }

    private function getKeysFromNode($prefix = '', $currPrefix, Node $node)
    {
        $keys = $this->isKeyPrefixWithValue($node, $prefix, $currPrefix)
            ? [ $currPrefix ]
            : [];

        foreach ($node->children as $child) {
            $newPrefix = $currPrefix . $child->key;

            if ($this->isPossibleMatch($prefix, $currPrefix, $newPrefix)) {
                $keys = array_merge($keys, $this->getKeysFromNode($prefix, $newPrefix, $child));
            }
        }

        return $keys;
    }

    private function isKeyPrefixWithValue(Node $node, $prefix, $acc)
    {
        return $node->isValue && ($prefix === '' || strpos($acc, $prefix) === 0);
    }

    public function getKeys()
    {
        return $this->getKeysFromNode('', '', $this->root);
    }

    public function count()
    {
        return $this->countFromNode($this->root);
    }

    private function countFromNode(Node $node)
    {
        return array_reduce(
            $node->children,
            function($acc, Node $n) { return $acc + $this->countFromNode($n); },
            $node->isValue ? 1 : 0
        );
    }
}

$t = new RadixTrie;

$t->insert('romane', 1);
$t->insert('romanus', 2);
$t->insert('romulus', 3);
$t->insert('rubens', 4);
$t->insert('ruber', 5);
$t->insert('rubicon', 6);
$t->insert('rubicundus', 7);

var_dump($t->getValue('romulus'));
var_dump($t->getKeys());
var_dump($t->getKeysWithPrefix('rubi'));
$t->remove('romulus');

var_dump($t);
var_dump(count($t));
