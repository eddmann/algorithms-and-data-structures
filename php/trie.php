<?php

class Trie implements \Countable
{
    private $value = null;
    private $isValue = false;
    private $nodes = [];

    public function insert($key, $value)
    {
        if ($head = $this->head($key)) {
            $node = isset($this->nodes[$head])
                ? $this->nodes[$head]
                : new self();

            if ($tail = $this->tail($key)) {
                $node->insert($tail, $value);
            } else {
                $node->setValue($value);
            }

            $this->nodes[$head] = $node;
        }
    }

    private function head($str)
    {
        return strlen($str) > 0
            ? $str[0]
            : null;
    }

    private function tail($str)
    {
        return strlen($str) > 1
            ? substr($str, 1)
            : null;
    }

    private function setValue($value)
    {
        $this->value = $value;
        $this->isValue = true;
    }

    public function remove($key)
    {
        if ($head = $this->head($key)) {
            if (isset($this->nodes[$head])) {
                $node = $this->nodes[$head];

                if ($tail = $this->tail($key)) {
                    $node->remove($tail);
                } else {
                    $node->clearValue();
                }

                if (count($this) === 0) {
                    unset($this->nodes[$head]);
                }
            }
        }
    }

    private function clearValue()
    {
        $this->value = null;
        $this->isValue = false;
    }

    public function keys($prefix = null)
    {
        $start = $prefix
            ? $this->getNode($prefix)
            : $this;

        return $start->buildKeys($prefix);
    }

    private function getNode($key)
    {
        if ($head = $this->head($key)) {
            if (isset($this->nodes[$head])) {
                $node = $this->nodes[$head];

                return ($tail = $this->tail($key))
                    ? $node->getNode($tail)
                    : $node;
            }
        }

        throw new Exception('Node does not exist.');
    }

    private function buildKeys($prefix)
    {
        $result = $this->isValue
            ? [ $prefix ]
            : [];

        foreach ($this->nodes as $key => $node) {
            $result = array_merge($result, $node->buildKeys($prefix . $key));
        }

        return $result;
    }

    public function count()
    {
        return array_reduce(
            $this->children(),
            function($acc, Trie $ele) { return $acc + count($ele); },
            $this->isValue ? 1 : 0
        );
    }

    private function children()
    {
        return array_values($this->nodes);
    }
}
