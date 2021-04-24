<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Months;
use Aeon\Calendar\Gregorian\Year;
use PHPUnit\Framework\TestCase;

final class MonthsTest extends TestCase
{
    public function test_array_access() : void
    {
        $months = Months::fromArray(
            Month::fromString('2002-01-01'),
            Month::fromString('2002-02-02'),
            Month::fromString('2002-03-03')
        );

        $this->assertTrue(isset($months->all()[0]));
        $this->assertInstanceOf(Month::class, $months->all()[0]);
        $this->assertSame(3, $months->count());
    }

    public function test_map() : void
    {
        $days = Months::fromArray(
            Month::fromString('2002-01-01'),
            Month::fromString('2002-02-02'),
            Month::fromString('2002-03-03')
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
        $months = Months::fromArray(
            Month::fromString('2002-01-01'),
            Month::fromString('2002-02-02'),
            Month::fromString('2002-03-03')
        );

        $this->assertEquals(
            Month::fromString('2002-01-01'),
            $months->filter(function (Month $day) {
                return $day->number() === 1;
            })->all()[0]
        );
    }

    public function test_slice_below_lower_limit() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Slice out of range.');

        (new Year(2020))->months()->slice(-1, 5);
    }

    public function test_slice_above_upper_limit() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Slice out of range.');

        (new Year(2020))->months()->slice(12, 1);
    }

    public function test_slice() : void
    {
        $this->assertSame(12, (new Year(2020))->months()->slice(11, 1)->all()[0]->number());
        $this->assertSame(2, (new Year(2020))->months()->slice(1, 1)->all()[0]->number());
        $this->assertSame(1, (new Year(2020))->months()->slice(0, 1)->all()[0]->number());
        $this->assertCount(5, (new Year(2020))->months()->slice(0, 5)->all());
    }
}
