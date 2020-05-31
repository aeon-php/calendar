<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Time;
use PHPUnit\Framework\TestCase;

final class TimeTest extends TestCase
{
    public function test_is_am() : void
    {
        $this->assertTrue((new Time(0, 0, 0, 0))->isAM());
        $this->assertfalse((new Time(0, 0, 0, 0))->isPM());
    }

    public function test_is_pm() : void
    {
        $this->assertFalse((Time::fromString('13:00:00'))->isAM());
        $this->assertTrue((Time::fromDateTime(new \DateTimeImmutable('13:00:00')))->isPM());
    }

    public function test_equal() : void
    {
        $this->assertTrue((new Time(10, 0, 0, 0))->isEqual(new Time(10, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isEqual(new Time(0, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isEqual(new Time(15, 0, 0, 0)));
    }

    public function test_greater() : void
    {
        $this->assertFalse((new Time(10, 0, 0, 0))->isGreaterThan(new Time(10, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isGreaterThan(new Time(0, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isGreaterThan(new Time(15, 0, 0, 0)));
    }

    public function test_greater_or_equal() : void
    {
        $this->assertTrue((new Time(10, 0, 0, 0))->isGreaterThanEq(new Time(10, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isGreaterThanEq(new Time(0, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isGreaterThanEq(new Time(15, 0, 0, 0)));
    }

    public function test_less() : void
    {
        $this->assertFalse((new Time(10, 0, 0, 0))->isLessThan(new Time(10, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isLessThan(new Time(0, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isLessThan(new Time(15, 0, 0, 0)));
    }

    public function test_less_or_equal() : void
    {
        $this->assertTrue((new Time(10, 0, 0, 0))->isLessThanEq(new Time(10, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isLessThanEq(new Time(0, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isLessThanEq(new Time(15, 0, 0, 0)));
    }
}
