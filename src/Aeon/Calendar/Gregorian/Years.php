<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @implements \IteratorAggregate<int, Year>
 * @implements \ArrayAccess<int, Year>
 */
final class Years implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array<int, Year>
     */
    private array $years;

    public function __construct(Year ...$years)
    {
        $this->years = $years;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->all()[(int) $offset]);
    }

    public function offsetGet($offset) : ?Year
    {
        return isset($this->all()[(int) $offset]) ? $this->all()[(int) $offset] : null;
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
     * @return array<int, Year>
     */
    public function all() : array
    {
        return $this->years;
    }

    /**
     * @param callable(Year $year) : mixed $iterator
     *
     * @return array<mixed>
     */
    public function map(callable $iterator) : array
    {
        return \array_map($iterator, $this->all());
    }

    /**
     * @param callable(Year $year) : bool $iterator
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
