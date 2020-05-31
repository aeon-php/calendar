<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @implements \IteratorAggregate<int,TimeInterval>
 * @implements \ArrayAccess<int,TimeInterval>
 */
final class TimeIntervals implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @var array<int, TimeInterval>
     */
    private array $intervals;

    public function __construct(TimeInterval ...$intervals)
    {
        $this->intervals = $intervals;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->all()[(int) $offset]);
    }

    public function offsetGet($offset) : ?TimeInterval
    {
        return isset($this->all()[(int) $offset]) ? $this->all()[(int) $offset] : null;
    }

    public function offsetSet($offset, $value) : void
    {
        throw new \RuntimeException(__CLASS__ . " is immutable.");
    }

    public function offsetUnset($offset) : void
    {
        throw new \RuntimeException(__CLASS__ . " is immutable.");
    }

    /**
     * @return array<int, TimeInterval>
     */
    public function all() : array
    {
        return $this->intervals;
    }

    /**
     * @param callable(TimeInterval $timeInterval) : void $iterator
     */
    public function each(callable $iterator) : void
    {
        \array_map(
            $iterator,
            $this->all()
        );
    }

    /**
     * @param callable(TimeInterval $timeInterval) : mixed $iterator
     * @return array<mixed>
     */
    public function map(callable $iterator) : array
    {
        return \array_map($iterator, $this->all());
    }

    /**
     * @param callable(TimeInterval $timeInterval) : bool $iterator
     * @return array<int, TimeInterval>
     */
    public function filter(callable $iterator) : array
    {
        return \array_filter($this->all(), $iterator);
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
