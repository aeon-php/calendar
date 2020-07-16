<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Months;
use PHPUnit\Framework\TestCase;

final class MonthsTest extends TestCase
{
    public function test_array_access() : void
    {
        $months = new Months(
            Month::fromString('2002-01-01'),
            Month::fromString('2002-02-02'),
            Month::fromString('2002-03-03'),
        );

        $this->assertTrue(isset($months[0]));
        $this->assertInstanceOf(Month::class, $months[0]);
        $this->assertSame(3, \iterator_count($months->getIterator()));
    }

    public function test_map() : void
    {
        $days = new Months(
            Month::fromString('2002-01-01'),
            Month::fromString('2002-02-02'),
            Month::fromString('2002-03-03'),
        );

        $this->assertSame(
            [1, 2, 3],
            $days->map(function (Month $day) {
                return $day->number();
            })
        );
    }

    public function test_filter() : void
    {
        $days = new Months(
            Month::fromString('2002-01-01'),
            Month::fromString('2002-02-02'),
            Month::fromString('2002-03-03'),
        );

        $this->assertEquals(
            new Months(Month::fromString('2002-01-01')),
            $days->filter(function (Month $day) {
                return $day->number() === 1;
            })
        );
    }
}
