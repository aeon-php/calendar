<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Time;
use Aeon\Calendar\Gregorian\TimeEpoch;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\Gregorian\TimeZone;
use Aeon\Calendar\Gregorian\TimeZone\TimeOffset;
use Aeon\Calendar\Gregorian\Year;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class DateTimeTest extends TestCase
{
    /**
     * @dataProvider creating_datetime_data_provider
     */
    public function test_creating_datetime(string $dateTimeString, DateTime $dateTime, string $format) : void
    {
        $this->assertSame($dateTimeString, $dateTime->format($format));
    }

    /**
     * @return \Generator<int, array{string, DateTime, string}, mixed, void>
     */
    public function creating_datetime_data_provider() : \Generator
    {
        yield ['2020-01-01 00:00:00+00:00', DateTime::fromString('2020-01-01 00:00:00+00:00'), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00', DateTime::create(2020, 01, 01, 00, 00, 00), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00', DateTime::fromDateTime(new \DateTimeImmutable('2020-01-01 00:00:00+00:00')), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00', new DateTime(new Day(new Month(new Year(2020), 01), 01), new Time(0, 0, 0)), 'Y-m-d H:i:sP'];

        yield ['2020-01-01 00:00:00+01:00', DateTime::fromString('2020-01-01 00:00:00+01:00'), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+01:00', DateTime::create(2020, 01, 01, 00, 00, 00, 0, 'Europe/Warsaw'), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+01:00', DateTime::fromDateTime(new \DateTimeImmutable('2020-01-01 00:00:00+01:00')), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+01:00', new DateTime(new Day(new Month(new Year(2020), 01), 01), new Time(0, 0, 0), TimeZone::europeWarsaw()), 'Y-m-d H:i:sP'];

        // DTS switch +1 hour
        yield ['2020-03-29 03:30:00+02:00', DateTime::fromString('2020-03-29 02:30:00 Europe/Warsaw'), 'Y-m-d H:i:sP'];
        // DTS switch -1 hour
        yield ['2020-10-25 02:30:00+01:00', DateTime::fromString('2020-10-25 02:30:00 Europe/Warsaw'), 'Y-m-d H:i:sP'];
        yield ['2020-10-25 01:30:00+02:00', DateTime::fromString('2020-10-25 01:30:00 Europe/Warsaw'), 'Y-m-d H:i:sP'];
    }

    public function test_create_without_timezone_and_time_offset() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:00.000000+0000',
            (new DateTime(new Day(new Month(new Year(2020), 1), 1), new Time(0, 0, 0)))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_create_with_timezone_and_without_time_offset() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:00.000000-0800',
            (new DateTime(new Day(new Month(new Year(2020), 1), 1), new Time(0, 0, 0), TimeZone::americaLosAngeles()))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_create_with_timezone_and_time_offset() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:00.000000-0800',
            (new DateTime(new Day(new Month(new Year(2020), 1), 1), new Time(0, 0, 0), TimeZone::americaLosAngeles(), TimeOffset::fromString('-08:00')))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_creating_datetime_with_timezone_not_matching_offset() : void
    {
        $this->expectExceptionMessage('TimeOffset +00:00 does not match TimeZone Europe/Warsaw at 2020-01-01 00:00:00');

        new DateTime(Day::fromString('2020-01-01'), new Time(0, 0, 0, 0), TimeZone::europeWarsaw(), TimeOffset::fromString('00:00'));
    }

    public function test_create_without_timezone_and_with_time_offset() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:00.000000-0800',
            (new DateTime(new Day(new Month(new Year(2020), 1), 1), new Time(0, 0, 0), null, TimeOffset::fromString('-08:00')))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_to_string() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');
        $this->assertSame($dateTime->toISO8601(), $dateTime->__toString());
    }

    public function test_create() : void
    {
        $this->assertTrue(
            DateTime::create(2020, 01, 01, 00, 00, 00, 0, 'America/Los_Angeles')
                ->isEqual(DateTime::fromString('2020-01-01 00:00:00 America/Los_Angeles'))
        );
    }

    public function test_create_date_just_after_daylight_saving_time_change() : void
    {
        $this->assertSame(
            '+02:00',
            DateTime::fromString('2020-10-25 01:00:00 Europe/Warsaw')->timeOffset()->toString()
        );
    }

    public function test_converting_timezone_just_after_daylight_saving_time() : void
    {
        $this->assertSame(
            '+02:00',
            DateTime::fromString('2020-10-25 00:30:00 Europe/Prague')
                ->toTimeZone(TimeZone::europePrague())
                ->timeOffset()->toString()
        );
    }

    public function test_from_timestamp() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00')->isEqual(DateTime::fromTimestampUnix(1577836800))
        );
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

        $this->assertFalse($dateTime->isDaylightSaving());
        $this->assertTrue($dateTime->isDaylight());
    }

    public function test_saving_time() : void
    {
        $dateTime = DateTime::fromString('2020-08-01 00:00:00')
            ->toTimeZone(new TimeZone('Europe/Warsaw'));

        $this->assertTrue($dateTime->isDaylightSaving());
        $this->assertFalse($dateTime->isDaylight());
    }

    public function test_unix_timestamp() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame(1577836800, $dateTime->timestampUNIX()->inSeconds());
    }

    public function test_timestamp() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00 UTC');

        $this->assertSame(1577836800, $dateTime->timestampUNIX()->inSeconds());
        $this->assertSame(1577836800, $dateTime->timestamp(TimeEpoch::UNIX())->inSeconds());
        $this->assertSame(1577836800, $dateTime->timestamp(TimeEpoch::POSIX())->inSeconds());
        $this->assertSame(1514764837, $dateTime->timestamp(TimeEpoch::UTC())->inSeconds());
        $this->assertSame(1261872018, $dateTime->timestamp(TimeEpoch::GPS())->inSeconds());
        $this->assertSame(1956528037, $dateTime->timestamp(TimeEpoch::TAI())->inSeconds());
    }

    public function test_to_atomic_time() : void
    {
        $now = DateTime::fromString('2020-06-17 20:57:07 UTC');

        $this->assertSame('2020-06-17T20:57:44+0000', $now->toAtomicTime()->toISO8601());
    }

    public function test_to_gps_time() : void
    {
        $now = DateTime::fromString('2020-06-17 20:57:07 UTC');

        $this->assertSame('2020-06-17T20:57:25+0000', $now->toGPSTime()->toISO8601());
    }

    public function test_timestamp_before_epoch_start() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Given epoch started at 1970-01-01T00:00:00+0000 which was after 1969-01-01T00:00:00+0000');

        $dateTime = DateTime::fromString('1969-01-01 00:00:00 UTC');

        $this->assertSame(1577836800, $dateTime->timestamp(TimeEpoch::UNIX())->inSeconds());
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
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00')
            ->iterate(
                DateTime::fromString('2020-01-02 00:00:00'),
                TimeUnit::hour()
            );

        $this->assertInstanceOf(TimePeriod::class, $timePeriods[0]);
        $this->assertSame('2020-01-01 00:00:00', $timePeriods[0]->start()->format('Y-m-d H:i:s'));
        $this->assertFalse($timePeriods[0]->distance()->isNegative());
        $this->assertSame('2020-01-01 01:00:00', $timePeriods[0]->end()->format('Y-m-d H:i:s'));
    }

    public function test_iterating_until_backward() : void
    {
        $timePeriods = DateTime::fromString('2020-01-02 00:00:00')
            ->iterate(
                DateTime::fromString('2020-01-01 00:00:00'),
                TimeUnit::hour()
            );

        $this->assertInstanceOf(TimePeriod::class, $timePeriods[0]);
        $this->assertSame('2020-01-02 00:00:00', $timePeriods[0]->start()->format('Y-m-d H:i:s'));
        $this->assertTrue($timePeriods[0]->distance()->isNegative());
        $this->assertSame('2020-01-01 23:00:00', $timePeriods[0]->end()->format('Y-m-d H:i:s'));
    }

    public function test_equal_dates_in_different_timezones() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00.100001')
                ->toTimeZone(TimeZone::australiaSydney())
                ->isEqual(
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

    public function test_distance_until() : void
    {
        $this->assertSame(
            1,
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->distanceUntil(DateTime::fromString('2020-01-01 01:00:00+00'))
                ->inHours()
        );
    }

    public function test_distance_since() : void
    {
        $this->assertSame(
            1,
            DateTime::fromString('2020-01-01 01:00:00+00')
                ->distanceSince(DateTime::fromString('2020-01-01 00:00:00+00'))
                ->inHours()
        );
    }

    /**
     * @dataProvider checking_ambiguous_time_data_provider
     */
    public function test_checking_is_ambiguous(DateTime $dateTime, bool $ambiguous) : void
    {
        $this->assertSame($ambiguous, $dateTime->isAmbiguous());
    }

    /**
     * @return \Generator<int, array{DateTime, bool}, mixed, void>
     */
    public function checking_ambiguous_time_data_provider() : \Generator
    {
        yield [DateTime::fromString('2020-10-25 01:59:59 Europe/Warsaw'), false];
        yield [DateTime::fromString('2020-10-25 02:00:00 Europe/Warsaw'), true];
        yield [DateTime::fromString('2020-10-25 02:59:59 Europe/Warsaw'), true];
        yield [DateTime::fromString('2020-10-25 03:00:00 Europe/Warsaw'), true];
        yield [DateTime::fromString('2020-10-25 03:01:00 Europe/Warsaw'), false];

        yield [DateTime::fromString('2020-03-29 01:59:59 Europe/Warsaw'), false];
        yield [DateTime::fromString('2020-03-29 02:00:00 Europe/Warsaw'), false];
        yield [DateTime::fromString('2020-03-29 02:59:59 Europe/Warsaw'), false];
        yield [DateTime::fromString('2020-03-29 03:00:00 Europe/Warsaw'), false];
        yield [DateTime::fromString('2020-03-29 03:01:00 Europe/Warsaw'), false];
    }

    public function test_using_create_constructor_during_dst_gap() : void
    {
        $this->assertSame(
            '03:30:00.000000',
            DateTime::create(2020, 03, 29, 02, 30, 00, 0, 'Europe/Warsaw')->time()->toString()
        );
    }

    public function test_using_constructor_during_dst_gap() : void
    {
        $this->assertSame(
            '03:30:00.000000',
            (new DateTime(
                new Day(new Month(new Year(2020), 03), 29),
                new Time(02, 30, 00, 0),
                TimeZone::europeWarsaw()
            ))->time()->toString()
        );
    }

    public function test_timezone_when_not_explicitly_provided() : void
    {
        $timeZone = DateTime::fromString('2020-03-29 00:00:00')->timeZone();

        $this->assertInstanceOf(TimeZone::class, $timeZone);
        $this->assertSame('UTC', $timeZone->name());
    }

    public function test_time_offset_when_not_explicitly_provided() : void
    {
        $this->assertSame('+00:00', DateTime::fromString('2020-03-29 00:00:00')->timeOffset()->toString());
    }

    public function test_time_offset_when_only_timezone_explicitly_provided() : void
    {
        $this->assertSame('+01:00', DateTime::fromString('2020-03-29 00:00:00 Europe/Warsaw')->timeOffset()->toString());
    }

    public function test_time_zone_when_only_timestamp_explicitly_provided() : void
    {
        $this->assertSame(null, DateTime::fromString('2020-01-01 01:00:00+0100')->timeZone());
    }

    public function test_yesterday() : void
    {
        $this->assertSame('2019-12-31T00:00:00+0000', DateTime::fromString('2020-01-01 01:00:00')->yesterday()->toISO8601());
    }

    public function test_yesterday_with_tz() : void
    {
        $this->assertSame('2019-12-31T00:00:00+0100', DateTime::fromString('2020-01-01 01:00:00 Europe/Warsaw')->yesterday()->toISO8601());
    }

    public function test_tomorrow() : void
    {
        $this->assertSame('2020-01-02T00:00:00+0000', DateTime::fromString('2020-01-01 01:00:00')->tomorrow()->toISO8601());
    }

    public function test_tomorrow_with_tz() : void
    {
        $this->assertSame('2020-01-02T00:00:00+0100', DateTime::fromString('2020-01-01 01:00:00 Europe/Warsaw')->tomorrow()->toISO8601());
    }
}
