<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Gregorian;

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
}