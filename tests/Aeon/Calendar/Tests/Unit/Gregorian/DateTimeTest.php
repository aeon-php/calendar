<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Time;
use Aeon\Calendar\Gregorian\TimeInterval;
use Aeon\Calendar\Gregorian\TimeZone;
use Aeon\Calendar\Gregorian\TimeZone\TimeOffset;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class DateTimeTest extends TestCase
{
    public function test_to_string() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');
        $this->assertSame($dateTime->toISO8601(), $dateTime->__toString());
    }

    public function test_creating_datetime_with_timezone_not_matching_offset() : void
    {
        $this->expectExceptionMessage('TimeOffset +00:00 does not match TimeZone Europe/Warsaw at 2020-01-01 00:00:00');

        new DateTime(Day::fromString('2020-01-01'), new Time(0, 0, 0, 0), TimeZone::europeWarsaw(), TimeOffset::fromString('00:00'));
    }

    public function test_year() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame(2020, $dateTime->year()->number());
    }

    public function test_month() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame(1, $dateTime->month()->number());
    }

    public function test_day() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame(1, $dateTime->day()->number());
    }

    public function test_time() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 12:54:23.001000');

        $this->assertSame(12, $dateTime->time()->hour());
        $this->assertSame(54, $dateTime->time()->minute());
        $this->assertSame(23, $dateTime->time()->second());
        $this->assertSame(1, $dateTime->time()->millisecond());
        $this->assertSame(1000, $dateTime->time()->microsecond());
    }

    public function test_creating_time_offset_from_timezone() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00')->toTimeZone(TimeZone::americaLosAngeles());

        $this->assertSame('-08:00', $dateTime->timeOffset()->toString());
    }

    public function test_timezone_conversion() : void
    {
        $dateTimeString = '2020-01-01 00:00:00.000000+0000';
        $dateTime = DateTime::fromString($dateTimeString);
        $timeZone = 'Europe/Warsaw';

        $this->assertSame(
            (new \DateTimeImmutable($dateTimeString))->setTimezone(new \DateTimeZone($timeZone))->format('Y-m-d H:i:s.uO'),
            $dateTime->toTimeZone(new TimeZone($timeZone))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_daylight() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00')
            ->toTimeZone(new TimeZone('Europe/Warsaw'));
        ;

        $this->assertFalse($dateTime->isDaylight());
        $this->assertTrue($dateTime->isSavingTime());
    }

    public function test_saving_time() : void
    {
        $dateTime = DateTime::fromString('2020-08-01 00:00:00')
            ->toTimeZone(new TimeZone('Europe/Warsaw'));

        $this->assertTrue($dateTime->isDaylight());
        $this->assertFalse($dateTime->isSavingTime());
    }

    public function test_timestamp() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame(1577836800, $dateTime->timestamp());
        $this->assertSame(1577836800, $dateTime->secondsSinceUnixEpoch());
    }

    public function test_add_hour() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame('2020-01-01T01:00:00+00:00', $dateTime->addHour()->format('c'));
    }

    public function test_sub_hour() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame('2019-12-31T23:00:00+00:00', $dateTime->subHour()->format('c'));
    }

    public function test_add_hours() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame('2020-01-01T05:00:00+00:00', $dateTime->addHours(5)->format('c'));
    }

    public function test_sub_hours() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame('2019-12-31T19:00:00+00:00', $dateTime->subHours(5)->format('c'));
    }

    public function test_iterating_until_forward() : void
    {
        $timeIntervals = DateTime::fromString('2020-01-01 00:00:00')
            ->until(
                DateTime::fromString('2020-01-02 00:00:00'),
                TimeUnit::hour()
            );

        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[0]);
        $this->assertSame('2020-01-01 00:00:00', $timeIntervals[0]->startDateTime()->format('Y-m-d H:i:s'));
        $this->assertFalse($timeIntervals[0]->interval()->isNegative());
        $this->assertSame('2020-01-01 01:00:00', $timeIntervals[0]->endDateTime()->format('Y-m-d H:i:s'));
    }

    public function test_iterating_until_backward() : void
    {
        $timeIntervals = DateTime::fromString('2020-01-02 00:00:00')
            ->until(
                DateTime::fromString('2020-01-01 00:00:00'),
                TimeUnit::hour()
            );

        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[0]);
        $this->assertSame('2020-01-02 00:00:00', $timeIntervals[0]->startDateTime()->format('Y-m-d H:i:s'));
        $this->assertTrue($timeIntervals[0]->interval()->isNegative());
        $this->assertSame('2020-01-01 23:00:00', $timeIntervals[0]->endDateTime()->format('Y-m-d H:i:s'));
    }

    public function test_equal_dates_in_different_timezones() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00.100001')
                ->toTimeZone(TimeZone::australiaSydney())
                ->isEquals(
                    DateTime::fromString('2020-01-01 00:00:00.100001')->toTimeZone(TimeZone::europeWarsaw())
                )
        );
    }

    public function test_add_second() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(1, $dateTime->addSecond()->time()->second());
    }

    public function test_add_seconds() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(5, $dateTime->addSeconds(5)->time()->second());
    }

    public function test_sub_second() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(59, $dateTime->subSecond()->time()->second());
    }

    public function test_sub_seconds() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(55, $dateTime->subSeconds(5)->time()->second());
    }

    public function test_add_minute() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(1, $dateTime->addMinute()->time()->minute());
    }

    public function test_add_minutes() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(5, $dateTime->addMinutes(5)->time()->minute());
    }

    public function test_sub_minute() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(59, $dateTime->subMinute()->time()->minute());
    }

    public function test_sub_minutes() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame(55, $dateTime->subMinutes(5)->time()->minute());
    }

    public function test_add_day() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2020-01-02 00:00:00+0000', $dateTime->addDay()->format('Y-m-d H:i:sO'));
    }

    public function test_add_days() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2020-01-03 00:00:00+0000', $dateTime->addDays(2)->format('Y-m-d H:i:sO'));
    }

    public function test_sub_day() : void
    {
        $dateTime = DateTime::fromString('2020-01-02 00:00:00+00');

        $this->assertSame('2020-01-01 00:00:00+0000', $dateTime->subDay()->format('Y-m-d H:i:sO'));
    }

    public function test_sub_days() : void
    {
        $dateTime = DateTime::fromString('2020-01-05 00:00:00+00');

        $this->assertSame('2020-01-01 00:00:00+0000', $dateTime->subDays(4)->format('Y-m-d H:i:sO'));
    }

    public function test_add_month() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2020-02-01 00:00:00+0000', $dateTime->addMonth()->format('Y-m-d H:i:sO'));
    }

    public function test_add_months() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2020-03-01 00:00:00+0000', $dateTime->addMonths(2)->format('Y-m-d H:i:sO'));
    }

    public function test_sub_month() : void
    {
        $dateTime = DateTime::fromString('2020-02-01 00:00:00+00');

        $this->assertSame('2020-01-01 00:00:00+0000', $dateTime->subMonth()->format('Y-m-d H:i:sO'));
    }

    public function test_sub_months() : void
    {
        $dateTime = DateTime::fromString('2020-03-01 00:00:00+00');

        $this->assertSame('2020-01-01 00:00:00+0000', $dateTime->subMonths(2)->format('Y-m-d H:i:sO'));
    }

    public function test_add_year() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2021-01-01 00:00:00+0000', $dateTime->addYear()->format('Y-m-d H:i:sO'));
    }

    public function test_add_years() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2022-01-01 00:00:00+0000', $dateTime->addYears(2)->format('Y-m-d H:i:sO'));
    }

    public function test_sub_year() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2019-01-01 00:00:00+0000', $dateTime->subYear()->format('Y-m-d H:i:sO'));
    }

    public function test_sub_years() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');

        $this->assertSame('2018-01-01 00:00:00+0000', $dateTime->subYears(2)->format('Y-m-d H:i:sO'));
    }

    public function test_add_timeunit() : void
    {
        $this->assertSame(
            '2020-01-01 01:00:00+0000',
            DateTime::fromString('2020-01-01 00:00:00+00')->add(TimeUnit::hour())->format('Y-m-d H:i:sO')
        );
    }

    public function test_add_precse_timeunit() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:02.500000+0000',
            DateTime::fromString('2020-01-01 00:00:00.000000+00')->add(TimeUnit::precise(2.500000))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_sub_timeunit() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:00+0000',
            DateTime::fromString('2020-01-01 01:00:00+00')->sub(TimeUnit::hour())->format('Y-m-d H:i:sO')
        );
    }

    public function test_sub_precse_timeunit() : void
    {
        $this->assertSame(
            '2020-01-01 00:59:58.500000+0000',
            DateTime::fromString('2020-01-01 01:00:00.000000+00')->sub(TimeUnit::precise(2.500000))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_is_after() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 01:00:00+00')
                ->isAfter(DateTime::fromString('2020-01-01 00:00:00+00'))
        );
    }

    public function test_is_before() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->isBefore(DateTime::fromString('2020-01-01 01:00:00+00'))
        );
    }

    public function test_is_after_or_equal() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->isAfterOrEqual(DateTime::fromString('2020-01-01 00:00:00+00'))
        );
    }

    public function test_is_before_or_equal() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->isBeforeOrEqual(DateTime::fromString('2020-01-01 00:00:00+00'))
        );
    }

    public function test_distance_to() : void
    {
        $this->assertSame(
            1,
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->distanceTo(DateTime::fromString('2020-01-01 01:00:00+00'))
                ->inHours()
        );
    }

    public function test_distance_from() : void
    {
        $this->assertSame(
            1,
            DateTime::fromString('2020-01-01 01:00:00+00')
                ->distanceFrom(DateTime::fromString('2020-01-01 00:00:00+00'))
                ->inHours()
        );
    }
}
