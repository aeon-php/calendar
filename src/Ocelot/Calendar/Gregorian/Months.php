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
        Assert::greaterThan($number, 0);
        Assert::lessThanEq($number, 12);

        return new Month($this->year, $number);
    }
}