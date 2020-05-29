<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Day;
use PHPUnit\Framework\TestCase;

final class DayTest extends TestCase
{
    public function test_midnight() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01T00:00:00+0000', $day->midnight()->toISO8601());
    }

    public function test_noon() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01T12:00:00+0000', $day->noon()->toISO8601());
    }

    public function test_end_of_day() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01 23:59:59.999999+0000', $day->endOfDay()->format('Y-m-d H:i:s.uO'));
    }

    public function test_week_of_year() : void
    {
        $day = Day::fromString('2020-02-01');

        $this->assertSame(5, $day->weekOfYear());
    }

    public function test_day_of_year() : void
    {
        $day = Day::fromString('2020-02-01');

        $this->assertSame(32, $day->dayOfYear());
    }

    public function test_week_day() : void
    {
        $this->assertSame(5, Day::fromString('2020-01-03')->weekDay()->number());
        $this->assertSame('Friday', Day::fromString('2020-01-03')->weekDay()->name());
        $this->assertSame('Fri', Day::fromString('2020-01-03')->weekDay()->shortName());
    }

    public function test_format() : void
    {
        $this->assertSame('2020-01-03', Day::fromString('2020-01-03')->format('Y-m-d'));
    }

    public function test_is_weekend() : void
    {
        $this->assertFalse(Day::fromString('2020-01-03')->isWeekend());
        $this->assertTrue(Day::fromString('2020-01-04')->isWeekend());
        $this->assertTrue(Day::fromString('2020-01-05')->isWeekend());
        $this->assertFalse(Day::fromString('2020-01-06')->isWeekend());
    }

    public function test_equal() : void
    {
        $this->assertTrue(Day::fromString('2020-01-01')->equals(Day::fromString('2020-01-01')));
    }
}
