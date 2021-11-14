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
        $this->assertTrue(WeekDay::monday()->isEqual(WeekDay::monday()));
        $this->assertTrue(WeekDay::tuesday()->isEqual(WeekDay::tuesday()));
        $this->assertTrue(WeekDay::wednesday()->isEqual(WeekDay::wednesday()));
        $this->assertTrue(WeekDay::thursday()->isEqual(WeekDay::thursday()));
        $this->assertTrue(WeekDay::friday()->isEqual(WeekDay::friday()));
        $this->assertTrue(WeekDay::saturday()->isEqual(WeekDay::saturday()));
        $this->assertTrue(WeekDay::sunday()->isEqual(WeekDay::sunday()));
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
