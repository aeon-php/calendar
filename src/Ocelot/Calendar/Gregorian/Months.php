<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

use Webmozart\Assert\Assert;

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

    public function byNumber(int $number) : Month
    {
        Assert::greaterThan($number, 0);
        Assert::lessThanEq($number, 12);

        return $this->months[$number - 1];
    }
}