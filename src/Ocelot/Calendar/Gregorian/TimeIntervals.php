<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @psalm-external-mutation-free
 * @implements \IteratorAggregate<int,TimeInterval>
 * @implements \ArrayAccess<int,TimeInterval>
 */
final class TimeIntervals implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @var array<TimeInterval>
     */
    private array $intervals;

    public function __construct(TimeInterval ...$intervals)
    {
        $this->intervals = $intervals;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->intervals[(int) $offset]);
    }

    public function offsetGet($offset) : ?TimeInterval
    {
        return isset($this->intervals[(int) $offset]) ? $this->intervals[(int) $offset] : null;
    }

    public function offsetSet($offset, $value) : void
    {
        throw new \RuntimeException(__CLASS__ . " is immutable.");
    }

    public function offsetUnset($offset) : void
    {
        throw new \RuntimeException(__CLASS__ . " is immutable.");
    }

    public function each(callable $iterator) : void
    {
        foreach ($this->intervals as $interval) {
            $iterator($interval);
        }
    }

    public function count() : int
    {
        return \count($this->intervals);
    }

    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->intervals);
    }
}