<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;

/**
 * @psalm-immutable
 */
final class YearMonths implements \Countable
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
        /** @psalm-suppress ImpureFunctionCall */
        return \array_map(
            fn (int $monthNumber) : Month => new Month($this->year, $monthNumber),
            \range(1, $this->year->numberOfMonths())
        );
    }

    /**
     * @psalm-param pure-callable(Month $day) : void $iterator
     *
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
     * @psalm-param pure-callable(Month $day) : bool $iterator
     *
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

    public function slice(int $from, int $size) : Months
    {
        if ($from < 0) {
            throw new InvalidArgumentException('Slice out of range.');
        }

        if ($from + $size > 12) {
            throw new InvalidArgumentException('Slice out of range.');
        }

        return Months::fromArray(...\array_slice($this->all(), $from, $size));
    }
}
