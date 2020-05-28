<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Month;
use PHPUnit\Framework\TestCase;

final class MonthTest extends TestCase
{
    public function test_first_day_of_month() : void
    {
        $month = Month::fromString('2020-01-01');

        $this->assertSame(1, $month->firstDay()->number());
    }

    public function test_last_day_of_month() : void
    {
        $month = Month::fromString('2020-01-01');

        $this->assertSame(31, $month->lastDay()->number());
    }

    public function test_next_month() : void
    {
        $this->assertSame(2, Month::fromString('2020-01-01')->next()->number());
    }

    public function test_previous_month() : void
    {
        $this->assertSame(1, Month::fromString('2020-02-01')->previous()->number());
    }

    public function test_name() : void
    {
        $this->assertSame('January', Month::fromString('2020-01-01')->name());
    }

    public function test_short_name() : void
    {
        $this->assertSame('Jan', Month::fromString('2020-01-01')->shortName());
    }
}
