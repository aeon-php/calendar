<?php

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
}