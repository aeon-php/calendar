<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @psalm-external-mutation-free
 */
final class Days implements \Countable
{
    private Month $month;

    /**
     * @var array<Day>
     */
    private array $days;

    public function __construct(Month $month)
    {
        $this->month = $month;
        $this->days = \array_map(
            fn(int $number): Day => new Day($month, $number),
            \range(1, $month->numberOfDays())
        );
    }

    public function count() : int
    {
        return \count($this->days);
    }

    public function first() : Day
    {
        return $this->days[\array_key_first($this->days)];
    }

    public function last() : Day
    {
        return $this->days[\array_key_last($this->days)];
    }
}