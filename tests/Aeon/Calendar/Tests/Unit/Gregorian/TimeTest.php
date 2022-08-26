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

    /**
     * @dataProvider invalid_string_day_format
     */
    public function test_from_invalid_string(string $invalidValue) : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value \"{$invalidValue}\" is not valid time format.");

        Time::fromString($invalidValue);
    }

    /**
     * @return \Generator<int, array{string}, mixed, void>
     */
    public function invalid_string_day_format() : \Generator
    {
        yield ['2020-32'];
    }

    public function test_each_part_of_time() : void
    {
        $time = Time::fromString('00:00');

        $this->assertSame(0, $time->hour());
        $this->assertSame(0, $time->minute());
        $this->assertSame(0, $time->second());
        $this->assertSame(0, $time->microsecond());
    }

    /**
     * @dataProvider valid_string_day_format
     */
    public function test_from_string(string $invalidValue, Time $time) : void
    {
        $this->assertObjectEquals($time, Time::fromString($invalidValue), 'isEqual');
    }

    /**
     * @return \Generator<int, array{string, Time}, mixed, void>
     */
    public function valid_string_day_format() : \Generator
    {
        yield ['01:00:01.5', new Time(01, 00, 01, 500000)];
        yield ['01:00:01.005', new Time(01, 00, 01, 5000)];
        yield ['01:00:01.00001', new Time(01, 00, 01, 10)];
        yield ['01:12', new Time(01, 12, 00)];
        yield ['01:12 +1 minute + 10 seconds', new Time(01, 13, 10)];
    }

    /**
     * @dataProvider creating_time_data_provider_from_string
     */
    public function test_creating_time_from_string(string $dateTime, string $format) : void
    {
        try {
            $this->assertEqualsWithDelta(
                (new \DateTime($dateTime))->getTimestamp(),
                (new \DateTime(Time::fromString($dateTime)->format($format)))->getTimestamp(),
                20,
                'Expected ' . (new \DateTime($dateTime))->format('c') . ' got ' . (new \DateTime(Time::fromString($dateTime)->format($format)))->format('c')
            );
        } catch (InvalidArgumentException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return \Generator<int, array{string, string, string}, mixed, void>
     */
    public function creating_time_data_provider_from_string() : \Generator
    {
        yield ['noW', 'H:i:s'];
        yield ['now ', 'H:i:s'];
        yield ['today', 'H:i:s'];
        yield [' tOday', 'H:i:s'];
        yield ['noon', 'H:i:s'];
        yield ['noon  ', 'H:i:s'];
        yield ['midnight  ', 'H:i:s'];
        yield ['noon +1 minute', 'H:i:s'];
        yield ['back of 7pm', 'H:i:s'];
        yield ['last hour', 'H:i:s'];
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
        $this->assertTrue((new Time(10, 0, 0, 0))->isEqualTo(new Time(10, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isEqualTo(new Time(0, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isEqualTo(new Time(15, 0, 0, 0)));
    }

    public function test_greater() : void
    {
        $this->assertFalse((new Time(10, 0, 0, 0))->isAfter(new Time(10, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isAfter(new Time(0, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isAfter(new Time(15, 0, 0, 0)));
    }

    public function test_greater_or_equal() : void
    {
        $this->assertTrue((new Time(10, 0, 0, 0))->isAfterOrEqualTo(new Time(10, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isAfterOrEqualTo(new Time(0, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isAfterOrEqualTo(new Time(15, 0, 0, 0)));
    }

    public function test_less() : void
    {
        $this->assertFalse((new Time(10, 0, 0, 0))->isBefore(new Time(10, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isBefore(new Time(0, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isBefore(new Time(15, 0, 0, 0)));
    }

    public function test_less_or_equal() : void
    {
        $this->assertTrue((new Time(10, 0, 0, 0))->isBeforeOrEqualTo(new Time(10, 0, 0, 0)));
        $this->assertFalse((new Time(10, 0, 0, 0))->isBeforeOrEqualTo(new Time(0, 0, 0, 0)));
        $this->assertTrue((new Time(10, 0, 0, 0))->isBeforeOrEqualTo(new Time(15, 0, 0, 0)));
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

    public function test_is_midnight() : void
    {
        $this->assertTrue(Time::fromString('00:00')->isMidnight());
        $this->assertTrue(Time::fromString('00:00:00')->isMidnight());

        $this->assertFalse(Time::fromString('15:00:00')->isMidnight());
        $this->assertFalse(Time::fromString('15:27:00')->isMidnight());
        $this->assertFalse(Time::fromString('15:27:28')->isMidnight());
        $this->assertFalse(Time::fromString('15:27:28.000001')->isMidnight());
    }

    public function test_is_not_midnight() : void
    {
        $this->assertTrue(Time::fromString('15:00:00')->isNotMidnight());
        $this->assertTrue(Time::fromString('15:27:00')->isNotMidnight());
        $this->assertTrue(Time::fromString('15:27:28')->isNotMidnight());
        $this->assertTrue(Time::fromString('15:27:28.000001')->isNotMidnight());

        $this->assertFalse(Time::fromString('00:00')->isNotMidnight());
        $this->assertFalse(Time::fromString('00:00:00')->isNotMidnight());
    }

    /**
     * @dataProvider compare_to_provider
     */
    public function test_compare_to(Time $time, Time $comparable, int $compareResult) : void
    {
        $this->assertSame($compareResult, $time->compareTo($comparable));
    }

    /**
     * @return \Generator<int, array{Time, Time, int}>
     */
    public function compare_to_provider() : \Generator
    {
        yield [Time::fromString('11:53:12'), Time::fromString('11:53:12'), 0];
        yield [Time::fromString('11:53'), Time::fromString('11:53'), 0];

        yield [Time::fromString('11:53:00'), Time::fromString('11:53:12'), -1];
        yield [Time::fromString('11:00:12'), Time::fromString('11:53:12'), -1];

        yield [Time::fromString('11:53:12'), Time::fromString('00:53:12'), 1];
        yield [Time::fromString('11:53:12'), Time::fromString('11:00:12'), 1];
    }
}
