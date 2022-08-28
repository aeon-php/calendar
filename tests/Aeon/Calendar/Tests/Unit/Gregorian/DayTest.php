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

    /**
     * @dataProvider creating_day_data_provider_from_string
     */
    public function test_creating_day_from_string(string $dateTimeString, string $dateTime, string $format) : void
    {
        try {
            $this->assertSame($dateTimeString, Day::fromString($dateTime)->format($format));
        } catch (InvalidArgumentException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return \Generator<int, array{string, string, string}, mixed, void>
     */
    public function creating_day_data_provider_from_string() : \Generator
    {
        yield [(new \DateTimeImmutable('now'))->format('Y-m-d 00:00:00+00:00'), 'now', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('now'))->format('Y-m-d 00:00:00+00:00'), 'now ', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('today'))->format('Y-m-d 00:00:00+00:00'), 'today', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('today'))->format('Y-m-d 00:00:00+00:00'), ' tOday', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('noon'))->format('Y-m-d 00:00:00+00:00'), 'noon', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('noon'))->format('Y-m-d 00:00:00+00:00'), 'noon  ', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('yesterday noon'))->format('Y-m-d 00:00:00+00:00'), 'yesterday noon', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('tomorrow'))->format('Y-m-d 00:00:00+00:00'), 'tomorrow', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('tomorrow midnight'))->format('Y-m-d 00:00:00+00:00'), 'tomorrow midnight', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('yesterday'))->format('Y-m-d 00:00:00+00:00'), 'yesterday', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('midnight'))->format('Y-m-d 00:00:00+00:00'), 'midnight', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('24 week'))->format('Y-m-d 00:00:00+00:00'), '24 week', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('today +1 hour'))->format('Y-m-d 00:00:00+00:00'), 'today +1 hour', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('tomorrow +1 hour'))->format('Y-m-d 00:00:00+00:00'), 'tomorrow +1 hour', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('-2 days'))->format('Y-m-d 00:00:00+00:00'), '-2 days', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('Monday'))->format('Y-m-d 00:00:00+00:00'), 'Monday', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('Monday next week'))->format('Y-m-d 00:00:00+00:00'), 'Monday next week', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('next year'))->format('Y-m-d 00:00:00+00:00'), 'next year', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('fifth day'))->format('Y-m-d 00:00:00+00:00'), 'fifth day', 'Y-m-d H:i:sP'];
        yield [(new \DateTimeImmutable('first day of January 2019'))->format('Y-m-d 00:00:00+00:00'), 'first day of January 2019', 'Y-m-d H:i:sP'];
    }

    public function test_to_string() : void
    {
        $this->assertSame(
            '2020-01-02',
            Day::fromString('2020-01-01 +1 day')->toString()
        );
    }

    /**
     * @dataProvider invalid_string_day_format
     */
    public function test_from_invalid_string(string $invalidValue) : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value \"{$invalidValue}\" is not valid day format.");

        Day::fromString($invalidValue);
    }

    /**
     * @return \Generator<int, array{string}, mixed, void>
     */
    public function invalid_string_day_format() : \Generator
    {
        yield ['2020-32'];
    }

    /**
     * @dataProvider valid_string_day_format
     */
    public function test_from_string(string $invalidValue, Day $month) : void
    {
        $this->assertObjectEquals($month, Day::fromString($invalidValue), 'isEqual');
    }

    /**
     * @return \Generator<int, array{string, Day}, mixed, void>
     */
    public function valid_string_day_format() : \Generator
    {
        yield ['2020-01', new Day(new Month(new Year(2020), 1), 1)];
        yield ['2020-01-02 +1 month', new Day(new Month(new Year(2020), 2), 2)];
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
        $this->assertTrue(Day::fromString('2020-01-01')->isEqualTo(Day::fromString('2020-01-01')));
        $this->assertFalse(Day::fromString('2020-01-02')->isEqualTo(Day::fromString('2020-01-01')));
    }

    public function test_is_before() : void
    {
        $this->assertTrue(Day::fromString('2019-01-01')->isBefore(Day::fromString('2020-01-01')));
        $this->assertFalse(Day::fromString('2019-01-01')->isBefore(Day::fromString('2019-01-01')));
        $this->assertTrue(Day::fromString('2020-01-01')->isBeforeOrEqualTo(Day::fromString('2020-01-01')));

        $this->assertFalse(Day::fromString('2021-01-01')->isBefore(Day::fromString('2020-01-01')));
        $this->assertFalse(Day::fromString('2021-01-01')->isBeforeOrEqualTo(Day::fromString('2020-01-01')));
        $this->assertTrue(Day::fromString('2020-01-01')->isBeforeOrEqualTo(Day::fromString('2020-05-01')));
        $this->assertTrue(Day::fromString('2020-05-01')->isAfterOrEqualTo(Day::fromString('2020-01-01')));
    }

    public function test_is_after() : void
    {
        $this->assertTrue(Day::fromString('2022-01-01')->isAfter(Day::fromString('2020-02-01')));
        $this->assertFalse(Day::fromString('2020-01-01')->isAfter(Day::fromString('2020-01-01')));
        $this->assertTrue(Day::fromString('2020-01-01')->isAfterOrEqualTo(Day::fromString('2020-01-01')));

        $this->assertFalse(Day::fromString('2019-01-01')->isAfter(Day::fromString('2020-02-01')));
        $this->assertFalse(Day::fromString('2019-01-01')->isAfterOrEqualTo(Day::fromString('2020-02-01')));
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
        $this->assertSame('2020-05-02', Day::fromString('2020-06-01')->subDays(30)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-05-31', Day::fromString('2020-06-01')->subDays(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-07-01', Day::fromString('2020-06-01')->addDays(30)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('2017-12-01', Day::fromString('2020-06-01')->subMonths(30)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-05-01', Day::fromString('2020-06-01')->subMonths(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2022-12-01', Day::fromString('2020-06-01')->addMonths(30)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('1990-06-01', Day::fromString('2020-06-01')->subYears(30)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-06-01', Day::fromString('2020-06-01')->subYears(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2050-06-01', Day::fromString('2020-06-01')->addYears(30)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('2020-01-01', Day::fromString('2020-01-01')->add(0, 0, 0)->format('Y-m-d'));
        $this->assertSame('2021-02-02', Day::fromString('2020-01-01')->add(1, 1, 1)->format('Y-m-d'));
        $this->assertSame('2018-11-30', Day::fromString('2020-01-01')->add(-1, -1, -1)->format('Y-m-d'));
        $this->assertSame('2021-02-02', Day::fromString('2020-01-01')->sub(-1, -1, -1)->format('Y-m-d'));
        $this->assertSame('2018-11-30', Day::fromString('2020-01-01')->sub(1, 1, 1)->format('Y-m-d'));
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
        $this->assertInstanceOf(Day::class, $days->all()[0]);
        $this->assertInstanceOf(Day::class, $days->all()[4]);
        $this->assertSame(1, $days->all()[0]->number());
        $this->assertSame(5, $days->all()[4]->number());
    }

    public function test_since() : void
    {
        $this->assertCount(5, $days = Day::fromString('2020-01-06')->since(Day::fromString('2020-01-01'), Interval::leftOpen()));
        $this->assertInstanceOf(Day::class, $days->all()[0]);
        $this->assertInstanceOf(Day::class, $days->all()[4]);
        $this->assertSame(6, $days->all()[0]->number());
        $this->assertSame(2, $days->all()[4]->number());
    }

    public function test_iterate_until() : void
    {
        $this->assertCount(5, $days = Day::fromString('2020-01-01')->iterate(Day::fromString('2020-01-06'), Interval::rightOpen()));
        $this->assertInstanceOf(Day::class, $days->all()[0]);
        $this->assertInstanceOf(Day::class, $days->all()[4]);
        $this->assertSame(1, $days->all()[0]->number());
        $this->assertSame(5, $days->all()[4]->number());
    }

    public function test_iterate_since() : void
    {
        $this->assertCount(5, $days = Day::fromString('2020-01-06')->iterate(Day::fromString('2020-01-01'), Interval::leftOpen()));
        $this->assertInstanceOf(Day::class, $days->all()[0]);
        $this->assertInstanceOf(Day::class, $days->all()[4]);
        $this->assertSame(6, $days->all()[0]->number());
        $this->assertSame(2, $days->all()[4]->number());
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
        $this->assertTrue(Day::fromString('2020-12-24')->isEqualTo($day));
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

        $this->assertObjectEquals(
            $day,
            \unserialize(\serialize($day)),
            'isEqual'
        );
    }

    /**
     * @dataProvider compare_to_provider
     */
    public function test_compare_to(Day $time, Day $comparable, int $compareResult) : void
    {
        $this->assertSame($compareResult, $time->compareTo($comparable));
    }

    /**
     * @return \Generator<int, array{Day, Day, int}>
     */
    public function compare_to_provider() : \Generator
    {
        yield [Day::fromString('2022-10-26'), Day::fromString('2022-10-26'), 0];
        yield [Day::fromString('2022-10'), Day::fromString('2022-10'), 0];

        yield [Day::fromString('2022-10-25'), Day::fromString('2022-10-26'), -1];
        yield [Day::fromString('2022-10-25'), Day::fromString('2022-11-25'), -1];

        yield [Day::fromString('2022-11-26'), Day::fromString('2022-10-26'), 1];
        yield [Day::fromString('2022-10-26'), Day::fromString('2022-10-25'), 1];
    }
}
