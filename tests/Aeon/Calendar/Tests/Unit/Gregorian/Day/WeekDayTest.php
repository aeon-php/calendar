<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian\Day;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Day\WeekDay;
use PHPUnit\Framework\TestCase;

final class WeekDayTest extends TestCase
{
    public function test_equals() : void
    {
        $this->assertTrue(WeekDay::monday()->isEqualTo(WeekDay::monday()));
        $this->assertTrue(WeekDay::tuesday()->isEqualTo(WeekDay::tuesday()));
        $this->assertTrue(WeekDay::wednesday()->isEqualTo(WeekDay::wednesday()));
        $this->assertTrue(WeekDay::thursday()->isEqualTo(WeekDay::thursday()));
        $this->assertTrue(WeekDay::friday()->isEqualTo(WeekDay::friday()));
        $this->assertTrue(WeekDay::saturday()->isEqualTo(WeekDay::saturday()));
        $this->assertTrue(WeekDay::sunday()->isEqualTo(WeekDay::sunday()));
    }

    public function test_create_for_week_day_less_than_0() : void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->assertTrue(new WeekDay(0));
    }

    public function test_create_for_week_day_greater_than_12() : void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->assertTrue(new WeekDay(8));
    }
}
