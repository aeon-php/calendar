<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @implements \IteratorAggregate<int, Month>
 * @implements \ArrayAccess<int, Month>
 */
final class Months implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array<int, Month>
     */
    private array $months;

    public function __construct(Month ...$months)
    {
        $this->months = $months;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->all()[\intval($offset)]);
    }

    public function offsetGet($offset) : ?Month
    {
        return isset($this->all()[\intval($offset)]) ? $this->all()[\intval($offset)] : null;
    }

    /** @codeCoverageIgnore */
    public function offsetSet($offset, $value) : void
    {
        throw new \RuntimeException(__CLASS__ . ' is immutable.');
    }

    /** @codeCoverageIgnore */
    public function offsetUnset($offset) : void
    {
        throw new \RuntimeException(__CLASS__ . ' is immutable.');
    }

    /**
     * @return array<int, Month>
     */
    public function all() : array
    {
        return $this->months;
    }

    /**
     * @param callable(Month $month) : mixed $iterator
     *
     * @return array<mixed>
     */
    public function map(callable $iterator) : array
    {
        return \array_map($iterator, $this->all());
    }

    /**
     * @param callable(Month $month) : bool $iterator
     */
    public function filter(callable $iterator) : self
    {
        return new self(...\array_filter($this->all(), $iterator));
    }

    public function count() : int
    {
        return \count($this->all());
    }

    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->all());
    }
}
