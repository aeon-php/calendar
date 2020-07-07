<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class Months implements \Countable
{
    private Year $year;

    public function __construct(Year $year)
    {
        $this->year = $year;
    }

    public function count() : int
    {
        return $this->year->numberOfMonths();
    }

    public function byNumber(int $number) : Month
    {
        return new Month($this->year, $number);
    }

    /**
     * @return array<int, Month>
     */
    public function all() : array
    {
        return \array_map(
            fn (int $monthNumber) : Month => new Month($this->year, $monthNumber),
            \range(1, $this->year->numberOfMonths())
        );
    }

    /**
     * @param callable(Month $day) : void $iterator
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
     * @param callable(Month $day) : bool $iterator
     *
     * @return array<Month>
     */
    public function filter(callable $iterator) : array
    {
        return \array_filter(
            $this->all(),
            $iterator
        );
    }
}
