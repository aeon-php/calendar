<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @implements \IteratorAggregate<int, Day>
 * @implements \ArrayAccess<int, Day>
 */
final class Days implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array<int, Day>
     */
    private array $days;

    public function __construct(Day ...$days)
    {
        $this->days = $days;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->all()[\intval($offset)]);
    }

    public function offsetGet($offset) : ?Day
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
     * @return array<int, Day>
     */
    public function all() : array
    {
        return $this->days;
    }

    /**
     * @psalm-template MapResultType
     *
     * @param callable(Day $day) : MapResultType $iterator
     *
     * @return array<MapResultType>
     */
    public function map(callable $iterator) : array
    {
        return \array_map($iterator, $this->all());
    }

    /**
     * @param callable(Day $day) : bool $iterator
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
