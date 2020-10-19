<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Time;
use Aeon\Calendar\Gregorian\TimeZone;
use Aeon\Calendar\Gregorian\Year;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class DayTest extends TestCase
{
    /**
     * @dataProvider create_day_with_invalid_number_provider
     */
    public function test_create_day_with_invalid_number(int $number) : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Day number must be greater or equal 1 and less or equal than 31');

        new Day(new Month(new Year(2020), 01), $number);
    }

    /**
     * @return \Generator<int, array{int}, mixed, void>
     */
    public function create_day_with_invalid_number_provider() : \Generator
    {
        yield [0];
        yield [32];
        yield [40];
    }

    public function test_debug_info() : void
    {
        $this->assertSame(
            [
                'year' => 2020,
                'month' => 1,
                'day' => 1,
            ],
            Day::fromString('2020-01-01')->__debugInfo()
        );
    }

    public function test_to_string() : void
    {
        $this->assertSame(
            '2020-01-01',
            Day::fromString('2020-01-01')->toString()
        );
    }

    public function test_midnight() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01 00:00:00.000000+00:00', $day->midnight(TimeZone::UTC())->format('Y-m-d H:i:s.uP'));
        $this->assertSame(2020, $day->year()->number());
    }

    public function test_noon() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01 12:00:00.000000+00:00', $day->noon(TimeZone::UTC())->format('Y-m-d H:i:s.uP'));
    }

    public function test_end_of_day() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01 23:59:59.999999+0000', $day->endOfDay(TimeZone::UTC())->format('Y-m-d H:i:s.uO'));
    }

    public function test_set_time() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame(
            '2020-01-01 11:00:00.000000+0100',
            $day->setTime(Time::fromString('11:00:00'), TimeZone::europeWarsaw())->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_next() : void
    {
        $day = Day::fromString('2020-01-01')->next();

        $this->assertSame('2020-01-02 00:00:00', $day->format('Y-m-d H:i:s'));
    }

    public function test_previous() : void
    {
        $day = Day::fromString('2020-01-02')->previous();

        $this->assertSame('2020-01-01 00:00:00', $day->format('Y-m-d H:i:s'));
    }

    public function test_week_of_year() : void
    {
        $day = Day::fromString('2020-02-01');

        $this->assertSame(5, $day->weekOfYear());
    }

    public function test_week_of_month() : void
    {
        $this->assertSame(1, Day::fromString('2020-01-05')->weekOfMonth());
        $this->assertSame(2, Day::fromString('2020-01-12')->weekOfMonth());
        $this->assertSame(3, Day::fromString('2020-01-19')->weekOfMonth());
        $this->assertSame(4, Day::fromString('2020-01-26')->weekOfMonth());
        $this->assertSame(5, Day::fromString('2020-01-31')->weekOfMonth());
        $this->assertSame(1, Day::fromString('2020-02-1')->weekOfMonth());
        $this->assertSame(2, Day::fromString('2020-02-9')->weekOfMonth());
        $this->assertSame(3, Day::fromString('2020-02-16')->weekOfMonth());
        $this->assertSame(4, Day::fromString('2020-02-23')->weekOfMonth());
        $this->assertSame(5, Day::fromString('2020-02-29')->weekOfMonth());
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

    public function test_is_equal() : void
    {
        $this->assertTrue(Day::fromString('2020-01-01')->isEqual(Day::fromString('2020-01-01')));
        $this->assertFalse(Day::fromString('2020-01-02')->isEqual(Day::fromString('2020-01-01')));
    }

    public function test_is_before() : void
    {
        $this->assertTrue(Day::fromString('2019-01-01')->isBefore(Day::fromString('2020-01-01')));
        $this->assertFalse(Day::fromString('2019-01-01')->isBefore(Day::fromString('2019-01-01')));
        $this->assertTrue(Day::fromString('2020-01-01')->isBeforeOrEqual(Day::fromString('2020-01-01')));

        $this->assertFalse(Day::fromString('2021-01-01')->isBefore(Day::fromString('2020-01-01')));
        $this->assertFalse(Day::fromString('2021-01-01')->isBeforeOrEqual(Day::fromString('2020-01-01')));
        $this->assertTrue(Day::fromString('2020-01-01')->isBeforeOrEqual(Day::fromString('2020-05-01')));
        $this->assertTrue(Day::fromString('2020-05-01')->isAfterOrEqual(Day::fromString('2020-01-01')));
    }

    public function test_is_after() : void
    {
        $this->assertTrue(Day::fromString('2022-01-01')->isAfter(Day::fromString('2020-02-01')));
        $this->assertFalse(Day::fromString('2020-01-01')->isAfter(Day::fromString('2020-01-01')));
        $this->assertTrue(Day::fromString('2020-01-01')->isAfterOrEqual(Day::fromString('2020-01-01')));

        $this->assertFalse(Day::fromString('2019-01-01')->isAfter(Day::fromString('2020-02-01')));
        $this->assertFalse(Day::fromString('2019-01-01')->isAfterOrEqual(Day::fromString('2020-02-01')));
    }

    public function test_reset_time_in_to_datetime_immutable() : void
    {
        $day = new Day(new Month(new Year(2020), 1), 1);

        $dateTimeImmutable1 = $day->toDateTimeImmutable();
        \sleep(1);
        $dateTimeImmutable2 = $day->toDateTimeImmutable();

        $this->assertTrue($dateTimeImmutable1 == $dateTimeImmutable2);
    }

    public function test_modify_months() : void
    {
        $this->assertSame('2020-05-02', Day::fromString('2020-06-01')->minusDays(30)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-05-31', Day::fromString('2020-06-01')->minusDays(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-07-01', Day::fromString('2020-06-01')->plusDays(30)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('2017-12-01', Day::fromString('2020-06-01')->minusMonths(30)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-05-01', Day::fromString('2020-06-01')->minusMonths(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2022-12-01', Day::fromString('2020-06-01')->plusMonths(30)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('1990-06-01', Day::fromString('2020-06-01')->minusYears(30)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-06-01', Day::fromString('2020-06-01')->minusYears(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2050-06-01', Day::fromString('2020-06-01')->plusYears(30)->toDateTimeImmutable()->format('Y-m-d'));

        $this->asserTsame('2021-02-02', Day::fromString('2020-01-01')->plus(1, 1, 1)->format('Y-m-d'));
        $this->asserTsame('2018-11-30', Day::fromString('2020-01-01')->minus(1, 1, 1)->format('Y-m-d'));
    }

    public function test_until_with_wrong_destination_month() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('1 January 2020 is after 1 January 2019');
        Day::fromString('2020-01-01')->until(Day::fromString('2019-01-01'), Interval::rightOpen());
    }

    public function test_since_with_wrong_destination_month() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('1 January 2019 is before 1 January 2020');
        Day::fromString('2019-01-01')->since(Day::fromString('2020-01-01'), Interval::rightOpen());
    }

    public function test_until() : void
    {
        $this->assertCount(5, $days = Day::fromString('2020-01-01')->until(Day::fromString('2020-01-06'), Interval::rightOpen()));
        $this->assertInstanceOf(Day::class, $days[0]);
        $this->assertInstanceOf(Day::class, $days[4]);
        $this->assertSame(1, $days[0]->number());
        $this->assertSame(5, $days[4]->number());
    }

    public function test_since() : void
    {
        $this->assertCount(5, $months = Day::fromString('2020-01-06')->since(Day::fromString('2020-01-01'), Interval::leftOpen()));
        $this->assertInstanceOf(Day::class, $months[0]);
        $this->assertInstanceOf(Day::class, $months[4]);
        $this->assertSame(5, $months[0]->number());
        $this->assertSame(1, $months[4]->number());
    }

    public function test_iterate_until() : void
    {
        $this->assertCount(5, $days = Day::fromString('2020-01-01')->iterate(Day::fromString('2020-01-06'), Interval::rightOpen()));
        $this->assertInstanceOf(Day::class, $days[0]);
        $this->assertInstanceOf(Day::class, $days[4]);
        $this->assertSame(1, $days[0]->number());
        $this->assertSame(5, $days[4]->number());
    }

    public function test_iterate_since() : void
    {
        $this->assertCount(5, $days = Day::fromString('2020-01-06')->iterate(Day::fromString('2020-01-01'), Interval::leftOpen()));
        $this->assertInstanceOf(Day::class, $days[0]);
        $this->assertInstanceOf(Day::class, $days[4]);
        $this->assertSame(5, $days[0]->number());
        $this->assertSame(1, $days[4]->number());
    }

    public function test_days_between() : void
    {
        $day1 = Day::fromString('2020-01-02');
        $day2 = Day::fromString('2020-01-01');
        $this->assertInstanceOf(TimeUnit::class, $day1->timeBetween($day2));
        $this->assertSame(1, $day1->timeBetween($day2)->inDays());
        $this->assertSame(1, $day2->timeBetween($day1)->inDays());
    }

    public function test_day_static_create() : void
    {
        $day = Day::create(2020, 12, 24);
        $this->assertTrue(Day::fromString('2020-12-24')->isEqual($day));
    }

    public function test_distance_to() : void
    {
        $this->assertSame(9, Day::create(2020, 01, 01)->distance(Day::create(2020, 01, 10))->inDays());
    }

    public function test_quarter() : void
    {
        $this->assertSame(1, Day::fromString('2020-01-01')->quarter()->number());
        $this->assertSame(2, Day::fromString('2020-04-01')->quarter()->number());
        $this->assertSame(3, Day::fromString('2020-07-01')->quarter()->number());
        $this->assertSame(4, Day::fromString('2020-10-01')->quarter()->number());
    }

    public function test_serialization() : void
    {
        $day = Day::create(2020, 01, 01);

        $this->assertSame(
            [
                'month' => $day->month(),
                'number' => $day->number(),
            ],
            $serializedDay = $day->__serialize()
        );
        $this->assertSame(
            'O:27:"' . Day::class . '":2:{s:5:"month";O:29:"' . Month::class . '":2:{s:4:"year";O:28:"' . Year::class . '":1:{s:4:"year";i:2020;}s:6:"number";i:1;}s:6:"number";i:1;}',
            $serializedDayString = \serialize($day)
        );
        $this->assertEquals(
            \unserialize($serializedDayString),
            $day
        );
    }
}
