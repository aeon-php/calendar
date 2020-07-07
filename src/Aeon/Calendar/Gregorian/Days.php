<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class Days implements \Countable
{
    private Month $month;

    public function __construct(Month $month)
    {
        $this->month = $month;
    }

    public function count() : int
    {
        return $this->month->numberOfDays();
    }

    public function first() : Day
    {
        return new Day($this->month, 1);
    }

    public function last() : Day
    {
        return new Day($this->month, $this->month->numberOfDays());
    }

    /**
     * @return array<int, Day>
     */
    public function all() : array
    {
        return \array_map(
            fn (int $dayNumber) : Day => new Day($this->month, $dayNumber),
            \range(1, $this->month->numberOfDays())
        );
    }

    /**
     * @param callable(Day $day) : void $iterator
     *
     * @return array<mixed>
     */
    public function map(callable $iterator) : array
    {
        return \array_map(
            $iterator,
            $this->all()
        );
    }

    /**
     * @param callable(Day $day) : bool $iterator
     *
     * @return array<Day>
     */
    public function filter(callable $iterator) : array
    {
        return \array_filter(
            $this->all(),
            $iterator
        );
    }
}
