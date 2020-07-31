<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Time;
use PHPUnit\Framework\TestCase;

final class TimeTest extends TestCase
{
    public function test_debug_info() : void
    {
        $this->assertSame(
            [
                'hour' => 0,
                'minute' => 0,
                'second' => 0,
                'microsecond' => 0,
            ],
            (new Time(0, 0, 0, 0))->__debugInfo()
        );
    }

    public function test_time_millisecond() : void
    {
        $this->assertSame(101, (new Time(0, 0, 0, 101999))->millisecond());
        $this->assertSame(0, (new Time(0, 0, 0, 0))->microsecond());
    }

    public function test_to_string() : void
    {
        $this->assertSame('23:59:59.599999', (new Time(23, 59, 59, 599999))->toString());
        $this->assertSame('00:00:00.000000', (new Time(0, 0, 0, 0))->toString());
    }

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

    public function test_to_time_unit() : void
    {
        $this->assertSame('36000.000000', ((new Time(10, 0, 0, 0))->toTimeUnit()->inSecondsPrecise()));
    }

    public function test_creating_using_invalid_hour() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Time(24, 0, 0, 0);
    }

    public function test_creating_using_invalid_minute() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Time(0, 60, 0, 0);
    }

    public function test_creating_using_invalid_second() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Time(0, 0, 60, 0);
    }

    public function test_creating_using_invalid_microsecond() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Time(0, 0, 0, 1_000_000);
    }
}
