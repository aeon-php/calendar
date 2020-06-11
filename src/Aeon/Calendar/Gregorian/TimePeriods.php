<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @implements \IteratorAggregate<int,TimePeriod>
 * @implements \ArrayAccess<int,TimePeriod>
 */
final class TimePeriods implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @var array<int, TimePeriod>
     */
    private array $periods;

    public function __construct(TimePeriod ...$periods)
    {
        $this->periods = $periods;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->all()[(int) $offset]);
    }

    public function offsetGet($offset) : ?TimePeriod
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
     * @return array<int, TimePeriod>
     */
    public function all() : array
    {
        return $this->periods;
    }

    /**
     * @param callable(TimePeriod $timePeriod) : void $iterator
     */
    public function each(callable $iterator) : void
    {
        \array_map(
            $iterator,
            $this->all()
        );
    }

    /**
     * @param callable(TimePeriod $timePeriod) : mixed $iterator
     * @return array<mixed>
     */
    public function map(callable $iterator) : array
    {
        return \array_map($iterator, $this->all());
    }

    /**
     * @param callable(TimePeriod $timePeriod) : bool $iterator
     * @return TimePeriods
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
