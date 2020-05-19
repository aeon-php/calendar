<?php

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @psalm-external-mutation-free
 */
final class Months implements \Countable
{
    /**
     * @var array<Month>
     */
    private array $months;

    public function __construct(Year $year)
    {
        $this->months = \array_map(
            fn(int $number) : Month => new Month($year, $number),
            \range(1, $year->numberOfMonths())
        );
    }

    public function count() : int
    {
        return \count($this->months);
    }
}