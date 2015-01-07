<?php

function stream($x, callable $f)
{
    while (true) {
        yield $x;
        $x = call_user_func($f, $x);
    }
}

function map(callable $f, Generator $g)
{
    while ($g->valid()) {
        yield call_user_func($f, $g->current());
        $g->next();
    }
}

function filter(callable $f, Generator $g)
{
    while ($g->valid()) {
        if (call_user_func($f, $g->current())) yield $g->current();
        $g->next();
    }
}

function take($n, Generator $g)
{
    while ($n--) {
        yield $g->current();
        $g->next();
    }
}

function srange($start = 1, $end = INF)
{
    return take($end - $start + 1, stream($start, function ($x) { return $x + 1; }));
}

class Stream implements Iterator
{
    const NIL_SENTINEL = null;

    private $head, $tail;
    private $current, $key;

    public function __construct($head, $tail = null)
    {
        $this->head = $head;
        $this->tail = $tail ?: function () { return self::nil(); };
    }

    public function map(callable $f)
    {
        if ($this->isNil()) return $this;

        return new self(call_user_func($f, $this->head), function () use ($f) {
            return $this->tail()->map($f);
        });
    }

    public function filter(callable $f)
    {
        if ($this->isNil()) return $this;

        if (call_user_func($f, $this->head)) {
            return new self($this->head, function () use ($f) {
                return $this->tail()->filter($f);
            });
        }

        return $this->tail()->filter($f);
    }

    public function take($n)
    {
        if ($this->isNil() || $n == 0) return self::nil();

        return new self($this->head, function () use ($n) {
            return $this->tail()->take($n - 1);
        });
    }

    public static function range($start = 1, $end = INF)
    {
        if ($start == $end) return new self($start);

        return new self($start, function () use ($start, $end) {
            return self::range($start + 1, $end);
        });
    }

    public function current()
    {
        return $this->current->head;
    }

    public function next()
    {
        $this->current = $this->current->tail();
        $this->key++;
    }

    public function key()
    {
        return $this->key;
    }

    public function valid()
    {
        return ! $this->current->isNil();
    }

    public function rewind()
    {
        $this->current = $this;
        $this->key = 0;
    }

    private function isNil()
    {
        return $this->head === self::NIL_SENTINEL;
    }

    private function tail()
    {
        return call_user_func($this->tail, $this->head);
    }

    private static function nil()
    {
        return new self(self::NIL_SENTINEL);
    }
}

function sprint($xs)
{
    echo '[' . implode(', ', iterator_to_array($xs)) . "]\n";
}

$isEven = function ($x) { return $x % 2 == 0; };

$fibonacci = call_user_func(function () {
    $y = 1;

    return function ($x) use (&$y) {
        $z = $y;
        $y += $x;
        return $z;
    };
});

sprint(take(10, filter($isEven, srange())));

sprint(take(10, stream(0, $fibonacci)));

sprint(Stream::range()->filter($isEven)->take(10));

$fibonacci = call_user_func(function () {
    $y = 1;

    return $f = function ($x) use (&$f, &$y) {
        $z = $y;
        $y += $x;

        return new Stream($z, function ($x) use (&$f) { return $f($x); });
    };
});

sprint((new Stream(0, $fibonacci))->take(10));