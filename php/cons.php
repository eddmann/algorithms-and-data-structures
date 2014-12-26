<?php

interface ConsList
{
    public function head();
    public function tail();
    public function foldr(Closure $fn, $acc);
    public function foldl(Closure $fn, $acc);
    public function map(Closure $fn);
    public function filter(Closure $fn);
    public function reverse();
    public function toArray();
}

class Nil implements ConsList
{
    public function head()
    {
        throw new RuntimeException;
    }

    public function tail()
    {
        throw new RuntimeException;
    }

    public function foldr(Closure $fn, $acc)
    {
        return $acc;
    }

    public function foldl(Closure $fn, $acc)
    {
        return $acc;
    }

    public function map(Closure $fn)
    {
        return $this;
    }

    public function filter(Closure $fn)
    {
        return $this;
    }

    public function reverse()
    {
        return $this;
    }

    public function toArray()
    {
        return [];
    }
}

class Cons implements ConsList
{
    private $head, $tail;

    public function __construct($head, ConsList $tail)
    {
        $this->head = $head;
        $this->tail = $tail;
    }

    public function head()
    {
        return $this->head;
    }

    public function tail()
    {
        return $this->tail;
    }

    public function foldr(Closure $fn, $acc)
    {
        return $fn($this->head(), $this->tail()->foldr($fn, $acc));
    }

    public function foldl(Closure $fn, $acc)
    {
        return $this->tail()->foldl($fn, $fn($this->head(), $acc));
    }

    public function map(Closure $fn)
    {
        return $this->foldr(function ($head, $acc) use ($fn) {
            return new Cons($fn($head), $acc);
        }, new Nil);
    }

    public function filter(Closure $fn)
    {
        return $this->foldr(function ($head, $acc) use ($fn) {
            return $fn($head) ? new Cons($head, $acc) : $acc;
        }, new Nil);
    }

    public function reverse()
    {
        return $this->foldl(function ($head, $acc) {
            return new Cons($head, $acc);
        }, new Nil);
    }

    public function toArray()
    {
        return array_merge([$this->head()], $this->tail()->toArray());
    }

    public static function from(array $xs)
    {
        return ($x = array_shift($xs)) ? new Cons($x, Cons::from($xs)) : new Nil;
    }
}

$xs = Cons::from(range(1, 10));

$isEven = function ($x) { return $x % 2 === 0; };
$count = function ($x, $acc) { return 1 + $acc; };
$times = function ($x, $acc) { return $x * $acc; };

$isFib = function ($x) {
    $isWhole = function ($y) { return abs($y - round($y)) < 0.0001; };

    return
        $isWhole(sqrt(5 * pow($x, 2) + 4)) ||
        $isWhole(sqrt(5 * pow($x, 2) - 4));
};

var_dump($xs->filter($isEven)->foldr($count, 0));
var_dump($xs->reverse()->foldr($times, 1));
var_dump($xs->foldr($times, 1));
var_dump($xs->filter($isFib)->foldr($count, 0));