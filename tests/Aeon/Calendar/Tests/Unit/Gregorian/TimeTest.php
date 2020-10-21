<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Time;
use Aeon\Calendar\TimeUnit;
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

    public function test_format() : void
    {
        $this->assertSame('23 59 59', (new Time(23, 59, 59, 599999))->format('H i s'));
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

    public function test_add() : void
    {
        $this->assertSame('01:00:00.000000', Time::fromString('00:00')->add(TimeUnit::hour())->toString());
        $this->assertSame('00:00:00.000000', Time::fromString('00:00')->add(TimeUnit::days(2))->toString());
        $this->assertSame('03:00:00.000000', Time::fromString('00:00')->add(TimeUnit::hours(27))->toString());
    }

    public function test_sub() : void
    {
        $this->assertSame('04:00:00.000000', Time::fromString('05:00')->sub(TimeUnit::hour())->toString());
        $this->assertSame('00:00:00.000000', Time::fromString('00:00')->sub(TimeUnit::days(2))->toString());
        $this->assertSame('21:00:00.000000', Time::fromString('00:00')->sub(TimeUnit::hours(27))->toString());
    }

    public function test_serialization() : void
    {
        $time = new Time(10, 00, 00, 00);

        $this->assertSame(
            [
                'hour' => 10,
                'minute' => 00,
                'second' => 00,
                'microsecond' => 00,
            ],
            $serializedTime = $time->__serialize()
        );
        $this->assertSame(
            'O:28:"' . Time::class . '":4:{s:4:"hour";i:10;s:6:"minute";i:0;s:6:"second";i:0;s:11:"microsecond";i:0;}',
            $serializedTimeString = \serialize($time)
        );
        $this->assertEquals(
            \unserialize($serializedTimeString),
            $time
        );
    }
}
