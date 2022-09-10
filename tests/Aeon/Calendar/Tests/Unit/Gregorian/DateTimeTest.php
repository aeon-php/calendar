<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Time;
use Aeon\Calendar\Gregorian\TimeEpoch;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\Gregorian\TimeZone;
use Aeon\Calendar\Gregorian\Year;
use Aeon\Calendar\RelativeTimeUnit;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class DateTimeTest extends TestCase
{
    public function setUp() : void
    {
        \date_default_timezone_set('UTC');
    }

    /**
     * @dataProvider creating_datetime_data_provider
     */
    public function test_creating_datetime(string $dateTimeString, DateTime $dateTime, string $format) : void
    {
        try {
            $this->assertSame($dateTimeString, $dateTime->format($format));
        } catch (InvalidArgumentException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return \Generator<int, array{string, DateTime, string}, mixed, void>
     */
    public function creating_datetime_data_provider() : \Generator
    {
        yield ['2020-01-01 00:00:00+00:00', DateTime::fromString('2020-01-01 00:00:00+00:00'), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00', DateTime::create(2020, 01, 01, 00, 00, 00), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00', DateTime::fromDateTime(new \DateTimeImmutable('2020-01-01 00:00:00+00:00')), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00', new DateTime(new Day(new Month(new Year(2020), 01), 01), new Time(0, 0, 0), TimeZone::UTC()), 'Y-m-d H:i:sP'];

        yield ['2020-11-01 02:00:00-08:00', DateTime::fromDateTime(new \DateTimeImmutable('2020-11-01 02:00 America/Los_Angeles')), 'Y-m-d H:i:sP'];

        yield ['2020-01-01 00:00:00+01:00', DateTime::fromString('2020-01-01 00:00:00+01:00'), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+01:00', DateTime::create(2020, 01, 01, 00, 00, 00, 0, 'Europe/Warsaw'), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+01:00', DateTime::fromDateTime(new \DateTimeImmutable('2020-01-01 00:00:00+01:00')), 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+01:00', new DateTime(new Day(new Month(new Year(2020), 01), 01), new Time(0, 0, 0), TimeZone::europeWarsaw()), 'Y-m-d H:i:sP'];
    }

    /**
     * @dataProvider creating_datetime_data_provider_from_string
     */
    public function test_creating_datetime_from_string(string $dateTimeString, string $dateTime, string $format) : void
    {
        try {
            $this->assertSame($dateTimeString, DateTime::fromString($dateTime)->format($format));
        } catch (InvalidArgumentException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return \Generator<int, array{string, string, string}, mixed, void>
     */
    public function creating_datetime_data_provider_from_string() : \Generator
    {
        yield ['2020-01-01 00:00:00+00:00', '2020-01 00:00:00', 'Y-m-d H:i:sP'];
        yield ['2020-01-02 00:00:00+00:00', '2020-01 00:00:00 +1 day', 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00', '2020-01 00:00', 'Y-m-d H:i:sP'];
        yield ['2020-01-01 00:00:00+00:00.000000', '2020-01 00:00', 'Y-m-d H:i:sP.u'];
        yield ['2020-01-01 00:00:00+00:00.000500', '2020-01 00:00:00.0005', 'Y-m-d H:i:sP.u'];
        yield ['1999-10-13 00:00:00', '1999-10-13 00:00:00', 'Y-m-d H:i:s'];
        yield ['1999-10-13 00:00:00', 'Oct 13  1999 00:00:00', 'Y-m-d H:i:s'];
        yield ['2000-01-19 00:00:00', '2000-01-19 00:00:00', 'Y-m-d H:i:s'];
        yield ['2000-01-19 00:00:00', 'Jan 19  2000 00:00:00', 'Y-m-d H:i:s'];
        yield ['2001-12-21 00:00:00', '2001-12-21 00:00:00', 'Y-m-d H:i:s'];
        yield ['2001-12-21 00:00:00', 'Dec 21  2001 00:00:00', 'Y-m-d H:i:s'];
        yield ['2001-12-21 12:16:00', '2001-12-21 12:16', 'Y-m-d H:i:s'];
        yield ['2001-12-21 12:16:00', 'Dec 21 2001 12:16', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:19:58', '2001-10-22 21:19:58', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:19:58', '2001-10-22 21:19:58-02', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:19:58', '2001-10-22 21:19:58-0213', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:19:58', '2001-10-22 21:19:58+02', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:19:58', '2001-10-22 21:19:58+0213', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:20:58', '2001-10-22T21:20:58-03:40', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:19:58', '2001-10-22T211958-2', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:19:58', '20011022T211958+0213', 'Y-m-d H:i:s'];
        yield ['2001-10-22 21:20:00', '20011022T21:20+0215', 'Y-m-d H:i:s'];
        yield ['1996-12-30 00:00:00', '1997W011 00:00:00', 'Y-m-d H:i:s'];
        yield ['2004-03-01 05:00:00', '2004W101T05:00+0', 'Y-m-d H:i:s'];
        // DTS switch +1 hour
        yield ['2020-03-29 03:30:00+02:00', '2020-03-29 02:30:00 Europe/Warsaw', 'Y-m-d H:i:sP'];
        // DTS switch -1 hour
        if (PHP_VERSION_ID >= 81000) {
            yield ['2020-10-25 02:30:00+02:00', '2020-10-25 02:30:00 Europe/Warsaw', 'Y-m-d H:i:sP'];
            yield ['2020-10-25 01:30:00+02:00', '2020-10-25 01:30:00 Europe/Warsaw', 'Y-m-d H:i:sP'];
        }
        // now
        yield [(new \DateTimeImmutable('now'))->format('Y-m-d'), 'now', 'Y-m-d'];
        yield [(new \DateTimeImmutable('now'))->format('Y-m-d'), 'noW', 'Y-m-d'];
        yield [(new \DateTimeImmutable('now GMT'))->format('Y-m-d'), 'noW GMT', 'Y-m-d'];
        yield [(new \DateTimeImmutable('now America/Los_Angeles'))->format('Y-m-d'), 'noW America/Los_Angeles', 'Y-m-d'];
        yield [(new \DateTimeImmutable('now +01:00'))->format('Y-m-d'), 'noW +01:00', 'Y-m-d'];
        // today
        yield [(new \DateTimeImmutable('today'))->format('Y-m-d'), 'today ', 'Y-m-d'];
        yield [(new \DateTimeImmutable('today America/Los_Angeles'))->format('Y-m-d'), 'today America/Los_Angeles', 'Y-m-d'];
        yield [(new \DateTimeImmutable('today +01:00'))->format('Y-m-d'), 'today +01:00', 'Y-m-d'];
        yield [(new \DateTimeImmutable('today GMT'))->format('Y-m-d'), 'today GMT', 'Y-m-d'];
        // noon
        yield [(new \DateTimeImmutable('noon'))->format('Y-m-d'), ' noON ', 'Y-m-d'];
        yield [(new \DateTimeImmutable('yesterday noon'))->format('Y-m-d'), 'yesterday noon', 'Y-m-d'];
        yield [(new \DateTimeImmutable('noon Europe/Warsaw'))->format('Y-m-d'), ' noON  Europe/Warsaw', 'Y-m-d'];
        // tomorrow
        yield [(new \DateTimeImmutable('tomorrow'))->format('Y-m-d'), 'tomorrow', 'Y-m-d'];
        yield [(new \DateTimeImmutable('tomorrow midnight'))->format('Y-m-d'), 'tomorrow midnight', 'Y-m-d'];
        yield [(new \DateTimeImmutable('tomorrow +01:00'))->format('Y-m-d'), 'tomorrow +01:00', 'Y-m-d'];
        // yesterday
        yield [(new \DateTimeImmutable('yesterday'))->format('Y-m-d'), 'yesterday', 'Y-m-d'];
        yield [(new \DateTimeImmutable('yesterday GMT'))->format('Y-m-d'), 'yesterday GMT', 'Y-m-d'];
        // midnight
        yield [(new \DateTimeImmutable('midnight'))->format('Y-m-d'), 'midnight', 'Y-m-d'];
        yield [(new \DateTimeImmutable('midnight PST'))->format('Y-m-d'), 'midnight  PST', 'Y-m-d'];
        yield [(new \DateTimeImmutable('24 week'))->format('Y-m-d'), '24 week', 'Y-m-d'];
        yield [(new \DateTimeImmutable('today +1 hour'))->format('Y-m-d'), 'today +1 hour', 'Y-m-d'];
        yield [(new \DateTimeImmutable('tomorrow +1 hour'))->format('Y-m-d'), 'tomorrow +1 hour', 'Y-m-d'];
        yield [(new \DateTimeImmutable('-2 days'))->format('Y-m-d'), '-2 days', 'Y-m-d'];
        yield [(new \DateTimeImmutable('Monday'))->format('Y-m-d'), 'Monday', 'Y-m-d'];
        yield [(new \DateTimeImmutable('Monday next week'))->format('Y-m-d'), 'Monday next week', 'Y-m-d'];
        yield [(new \DateTimeImmutable('next year'))->format('Y-m-d'), 'next year', 'Y-m-d'];
        yield [(new \DateTimeImmutable('fifth day'))->format('Y-m-d'), 'fifth day', 'Y-m-d'];
        yield [(new \DateTimeImmutable('last day'))->format('Y-m-d'), 'last day', 'Y-m-d'];
        yield [(new \DateTimeImmutable('first day of January 2019'))->format('Y-m-d'), 'first day of January 2019', 'Y-m-d'];
    }

    /**
     * @dataProvider invalid_date_time_string
     */
    public function test_creating_datetime_from_invalid_string(string $dateTimeInvalidString) : void
    {
        $this->expectExceptionMessage("Value \"{$dateTimeInvalidString}\" is not valid date time format.");
        $this->expectException(InvalidArgumentException::class);

        DateTime::fromString($dateTimeInvalidString);
    }

    /**
     * @return \Generator<int, array{string}, mixed, void>
     */
    public function invalid_date_time_string() : \Generator
    {
        yield ['2020-31-01'];
        yield ['2020-01-32'];
        yield ['something'];
    }

    public function test_creating_datetime_from_string_relative_with_system_default_timezone_different_from_UTC() : void
    {
        \date_default_timezone_set('Europe/Warsaw');

        $dateTime = DateTime::fromString('tomorrow');

        $this->assertSame('UTC', $dateTime->timeZone()->name());
        $this->assertSame('Europe/Warsaw', \date_default_timezone_get());
    }

    public function test_creating_datetime_from_string_relative_with_timezone_and_with_system_default_timezone_different_from_UTC() : void
    {
        \date_default_timezone_set('Europe/Warsaw');

        $dateTime = DateTime::fromString('tomorrow PST');

        $this->assertSame('PST', $dateTime->timeZone()->name());
        $this->assertSame('Europe/Warsaw', \date_default_timezone_get());
    }

    public function test_debug_info() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00 America/Los_Angeles');

        $this->assertSame(
            [
                'datetime' => $dateTime->toISO8601(),
                'day' => $dateTime->day(),
                'time' => $dateTime->time(),
                'timeZone' => $dateTime->timeZone(),
            ],
            $dateTime->__debugInfo()
        );
    }

    public function test_create_with_timezone_and_without_time_offset() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:00.000000-0800',
            (new DateTime(new Day(new Month(new Year(2020), 1), 1), new Time(0, 0, 0), TimeZone::americaLosAngeles()))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_create_from_string_without_offset_and_timezone() : void
    {
        $this->assertSame(
            'UTC',
            DateTime::fromString('2020-01-01 00:00:00')->timeZone()->name()
        );
    }

    public function test_create_from_string_with_default_system_timezone() : void
    {
        \date_default_timezone_set('Europe/Warsaw');

        $this->assertSame(
            'UTC',
            DateTime::fromString('2020-01-01 00:00:00')->timeZone()->name()
        );
        $this->assertSame('Europe/Warsaw', \date_default_timezone_get());
    }

    public function test_create_from_timestamp_with_default_system_timezone() : void
    {
        \date_default_timezone_set('Europe/Warsaw');

        $this->assertSame(
            'UTC',
            DateTime::fromTimestampUnix(1577836800)->timeZone()->name()
        );

        $this->assertSame('Europe/Warsaw', \date_default_timezone_get());
    }

    public function test_compare_objects_create_through_different_constructors() : void
    {
        \date_default_timezone_set('Europe/Warsaw');

        $dateTimeFromString = DateTime::fromString('2020-01-01 00:00:00');
        $dateTimeFromTimestamp = DateTime::fromTimestampUnix(1577836800);
        $dateTimeCreate = DateTime::create(2020, 01, 01, 00, 00, 00);
        $dateTime = new DateTime(new Day(new Month(new Year(2020), 01), 01), new Time(00, 00, 00), TimeZone::UTC());

        $this->assertTrue($dateTime->isEqualTo($dateTimeFromString));
        $this->assertTrue($dateTime->isEqualTo($dateTimeFromTimestamp));
        $this->assertTrue($dateTime->isEqualTo($dateTimeCreate));

        $this->assertTrue($dateTimeFromString->isEqualTo($dateTimeCreate));
        $this->assertTrue($dateTimeFromString->isEqualTo($dateTimeFromTimestamp));

        $this->assertTrue($dateTimeFromTimestamp->isEqualTo($dateTimeCreate));
    }

    public function test_compare_source_datetime_immutable_with_converted_one() : void
    {
        $dateTimeImmutable = new \DateTimeImmutable('2020-01-01 00:00:00');

        $dateTime = DateTime::fromDateTime($dateTimeImmutable);

        $this->assertEquals($dateTimeImmutable, $dateTime->toDateTimeImmutable());
    }

    public function test_compare_source_datetime_immutable_with_timezone_with_converted_one() : void
    {
        $dateTimeImmutable = new \DateTimeImmutable('2020-01-01 00:00:00 America/Los_Angeles');

        $dateTime = DateTime::fromDateTime($dateTimeImmutable);

        $this->assertEquals($dateTimeImmutable, $dateTime->toDateTimeImmutable());
    }

    public function test_compare_source_from_string_with_timezone_with_converted_one() : void
    {
        $dateTimeImmutable = new \DateTimeImmutable('2020-01-01 00:00:00 America/Los_Angeles');

        $dateTime = DateTime::fromString('2020-01-01 00:00:00 America/Los_Angeles');

        $this->assertEquals($dateTimeImmutable, $dateTime->toDateTimeImmutable());
    }

    public function test_create_from_string_with_timezone() : void
    {
        $this->assertSame(
            '2020-01-01 00:00:00.000000-0800',
            DateTime::fromString('2020-01-01 00:00:00 America/Los_Angeles')->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_to_string() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');
        $this->assertSame($dateTime->toISO8601(), $dateTime->__toString());
    }

    public function test_to_iso8601_extended_format() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');
        $this->assertSame('2020-01-01T00:00:00+00:00', $dateTime->toISO8601());
    }

    public function test_to_iso8601_basic_format() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00+00');
        $this->assertSame('20200101T000000+0000', $dateTime->toISO8601($extended = false));
    }

    public function test_create() : void
    {
        $this->assertTrue(
            DateTime::create(2020, 01, 01, 00, 00, 00, 0, 'America/Los_Angeles')
                ->isEqualTo(DateTime::fromString('2020-01-01 00:00:00 America/Los_Angeles'))
        );
    }

    public function test_create_with_default_values() : void
    {
        $this->assertTrue(
            DateTime::create(2020, 01, 01, 00, 00, 00)
                ->isEqualTo(DateTime::fromString('2020-01-01 00:00:00.000000 UTC'))
        );
    }

    public function test_from_timestamp() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00')->isEqualTo(DateTime::fromTimestampUnix(1577836800))
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

    public function test_midnight() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00 UTC');

        $this->assertSame('2020-01-01 00:00:00.000000+00:00', $dateTime->midnight()->format('Y-m-d H:i:s.uP'));
    }

    public function test_noon() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00 UTC');

        $this->assertSame('2020-01-01 12:00:00.000000+00:00', $dateTime->noon()->format('Y-m-d H:i:s.uP'));
    }

    public function test_end_of_day() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00 UTC');

        $this->assertSame('2020-01-01 23:59:59.999999+00:00', $dateTime->endOfDay()->format('Y-m-d H:i:s.uP'));
    }

    public function test_modify_with_non_relative_value() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value "2020-02-03 00:00:00 UTC" is not valid relative time format.');

        DateTime::fromString('2020-01-01 00:00:00 UTC')->modify('2020-02-03 00:00:00 UTC');
    }

    /**
     * @dataProvider modify_datetime
     */
    public function test_modify(string $date, string $modifier, string $expectedDate) : void
    {
        $this->assertSame(
            $expectedDate,
            DateTime::fromString($date)->modify($modifier)->format('Y-m-d H:i:s T')
        );
    }

    /**
     * @return \Generator<int, array{string, string, string}, mixed, void>
     */
    public function modify_datetime() : \Generator
    {
        yield ['2021-01-31 00:00:00 UTC', '+1 second', '2021-01-31 00:00:01 UTC'];
        yield ['2021-01-31 00:00:00 UTC', '+1 minute', '2021-01-31 00:01:00 UTC'];
        yield ['2021-01-31 00:00:00 UTC', '+1 hour', '2021-01-31 01:00:00 UTC'];
        yield ['2021-01-31 00:00:00 UTC', '+1 day', '2021-02-01 00:00:00 UTC'];
        yield ['2021-01-31 00:00:00 UTC', '+1 week', '2021-02-07 00:00:00 UTC'];

        yield ['2021-01-31 00:00:00 UTC', '+1 fortnight', '2021-02-14 00:00:00 UTC'];

        yield ['2020-01-01 00:00:00 UTC', '+1 hour', '2020-01-01 01:00:00 UTC'];
        yield ['2020-01-01 00:00:00 UTC', '1 hour', '2020-01-01 01:00:00 UTC'];
        yield ['2020-01-01 00:00:00 UTC', '-1 hour', '2019-12-31 23:00:00 UTC'];

        yield ['2021-03-30 00:00:00 UTC', '-1 month', '2021-02-28 00:00:00 UTC'];
        yield ['2021-02-28 00:00:00 UTC', '+1 month', '2021-03-28 00:00:00 UTC'];
        yield ['2021-01-31 00:00:00 UTC', '+1 month', '2021-02-28 00:00:00 UTC'];
        yield ['2021-01-31 00:00:00 UTC', '+2 month', '2021-03-31 00:00:00 UTC'];

        yield ['2021-01-31 00:00:00 UTC', '+1 year', '2022-01-31 00:00:00 UTC'];
        yield ['2021-01-31 00:00:00 UTC', '-1 year', '2020-01-31 00:00:00 UTC'];

        yield ['2022-10-25 15:00:00 UTC', 'next Saturday', '2022-10-29 15:00:00 UTC'];
        yield ['2022-10-25 15:00:00 UTC', 'previous Saturday', '2022-10-22 15:00:00 UTC'];
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

    public function test_timezone_conversion() : void
    {
        $dateTimeString = '2020-01-01 00:00:00.000000+0000';
        $dateTime = DateTime::fromString($dateTimeString);
        $timeZone = 'Europe/Warsaw';

        $this->assertSame(
            (new \DateTimeImmutable($dateTimeString))->setTimezone(new \DateTimeZone($timeZone))->format('Y-m-d H:i:s.uO'),
            $dateTime->toTimeZone(TimeZone::fromString($timeZone))->format('Y-m-d H:i:s.uO')
        );
    }

    public function test_daylight() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00')
            ->toTimeZone(TimeZone::fromString('Europe/Warsaw'));

        $this->assertFalse($dateTime->isDaylightSaving());
        $this->assertTrue($dateTime->isDaylight());
    }

    public function test_saving_time() : void
    {
        $dateTime = DateTime::fromString('2020-08-01 00:00:00')
            ->toTimeZone(TimeZone::fromString('Europe/Warsaw'));

        $this->assertTrue($dateTime->isDaylightSaving());
        $this->assertFalse($dateTime->isDaylight());
    }

    public function test_unix_timestamp() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame(1577836800, $dateTime->timestampUNIX()->inSeconds());
    }

    public function test_unix_zero_timestamp() : void
    {
        $dateTime = DateTime::fromString('1970-01-01 00:00:00');

        $this->assertSame(0, $dateTime->timestampUNIX()->inSeconds());
        $this->assertTrue($dateTime->timestampUNIX()->isPositive());
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

        $this->assertSame('2020-06-17T20:57:44+00:00', $now->toAtomicTime()->toISO8601());
    }

    public function test_to_gps_time() : void
    {
        $now = DateTime::fromString('2020-06-17 20:57:07 UTC');

        $this->assertSame('2020-06-17T20:57:25+00:00', $now->toGPSTime()->toISO8601());
    }

    public function test_timestamp_before_epoch_start() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Given epoch started at 1970-01-01T00:00:00+00:00 which was after 1969-01-01T00:00:00+00:00');

        $dateTime = DateTime::fromString('1969-01-01 00:00:00 UTC');

        $this->assertSame(1577836800, $dateTime->timestamp(TimeEpoch::UNIX())->inSeconds());
    }

    public function test_add_hour() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00');

        $this->assertSame('2020-01-01T01:00:00+00:00', $dateTime->addHour()->format('c'));
    }

    public function test_add_hour_during_ambiguous_time() : void
    {
        $dateTime = DateTime::fromString('2020-11-01 01:30:00 America/Los_Angeles');
        $dateTime = DateTime::fromString(
            $dateTime->add(TimeUnit::minutes(30))->format('Y-m-d H:i:s.u') . ' America/Los_Angeles'
        );

        $this->assertSame('2020-11-01T01:00:00-07:00', $dateTime->toISO8601());
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

        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[0]);
        $this->assertSame('2020-01-01 00:00:00', $timePeriods->all()[0]->start()->format('Y-m-d H:i:s'));
        $this->assertFalse($timePeriods->all()[0]->distance()->isNegative());
        $this->assertSame('2020-01-01 01:00:00', $timePeriods->all()[0]->end()->format('Y-m-d H:i:s'));
    }

    public function test_iterating_until_backward() : void
    {
        $timePeriods = DateTime::fromString('2020-01-02 00:00:00')
            ->iterate(
                DateTime::fromString('2020-01-01 00:00:00'),
                TimeUnit::hour()
            );

        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[0]);
        $this->assertSame('2020-01-02 00:00:00', $timePeriods->all()[0]->start()->format('Y-m-d H:i:s'));
        $this->assertTrue($timePeriods->all()[0]->distance()->isNegative());
        $this->assertSame('2020-01-01 23:00:00', $timePeriods->all()[0]->end()->format('Y-m-d H:i:s'));
    }

    public function test_equal_dates_in_different_timezones() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00.100001')
                ->toTimeZone(TimeZone::australiaSydney())
                ->isEqualTo(
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

    public function test_add_2_months_to_the_last_day_of_march() : void
    {
        $dateTime = DateTime::fromString('2020-03-31 00:00:00+00');

        $this->assertSame('2020-04-30 00:00:00+0000', $dateTime->addMonths(1)->format('Y-m-d H:i:sO'));
    }

    public function test_sub_month() : void
    {
        $dateTime = DateTime::fromString('2020-02-01 00:00:00+00');

        $this->assertSame('2020-01-01 00:00:00+0000', $dateTime->subMonth()->format('Y-m-d H:i:sO'));
    }

    public function test_sub_month_from_day_before_last_day_of_march() : void
    {
        $dateTime = DateTime::fromString('2021-03-30 00:00:00+00');

        $this->assertSame('2021-02-28 00:00:00+0000', $dateTime->subMonth()->format('Y-m-d H:i:sO'));
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

    public function test_add_timeunit_hour() : void
    {
        $this->assertSame(
            '2020-01-01 01:00:00+0000',
            DateTime::fromString('2020-01-01 00:00:00+00')->add(TimeUnit::hour())->format('Y-m-d H:i:sO')
        );
    }

    /**
     * @dataProvider add_relative_timeunit_months
     */
    public function test_add_relative_timeunit_months(string $date, int $addMonths, string $expectedDate) : void
    {
        $this->assertSame(
            $expectedDate,
            DateTime::fromString($date)->add(RelativeTimeUnit::months($addMonths))->format('Y-m-d')
        );
    }

    /**
     * @return \Generator<int, array{string, int, string}, mixed, void>
     */
    public function add_relative_timeunit_months() : \Generator
    {
        yield ['2020-01-01', 1, '2020-02-01'];
        yield ['2020-01-01', 6, '2020-07-01'];
        yield ['2020-01-01', 12, '2021-01-01'];
        yield ['2020-01-01', 16, '2021-05-01'];
    }

    /**
     * @dataProvider sub_relative_timeunit_months
     */
    public function test_sub_relative_timeunit_months(string $date, int $addMonths, string $expectedDate) : void
    {
        $this->assertSame(
            $expectedDate,
            DateTime::fromString($date)->sub(RelativeTimeUnit::months($addMonths))->format('Y-m-d')
        );
    }

    /**
     * @return \Generator<int, array{string, int, string}, mixed, void>
     */
    public function sub_relative_timeunit_months() : \Generator
    {
        yield ['2020-01-01', 1, '2019-12-01'];
        yield ['2020-01-01', 6, '2019-07-01'];
        yield ['2020-01-01', 12, '2019-01-01'];
        yield ['2020-01-01', 16, '2018-09-01'];
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
            '2020-01-01 00:59:57.500000+0000',
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
        $this->assertFalse(
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->isBefore(DateTime::fromString('2020-01-01 00:00:00+00'))
        );
    }

    public function test_is_after_or_equal() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->isAfterOrEqualTo(DateTime::fromString('2020-01-01 00:00:00+00'))
        );
    }

    public function test_is_before_or_equal() : void
    {
        $this->assertTrue(
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->isBeforeOrEqualTo(DateTime::fromString('2020-01-01 00:00:00+00'))
        );
    }

    public function test_until() : void
    {
        $this->assertSame(
            1,
            DateTime::fromString('2020-01-01 00:00:00+00')
                ->until(DateTime::fromString('2020-01-01 01:00:00+00'))
                ->distance()
                ->inHours()
        );
    }

    public function test_until_with_date_before_datetime() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Backward DateTimeIterator 2020-01-01 00:00:00+00:00...2019-12-01 01:00:00+00:00 requires negative TimeUnit');

        DateTime::fromString('2020-01-01 00:00:00+00')
            ->until(DateTime::fromString('2019-12-01 01:00:00+00'))
            ->iterate(TimeUnit::day(), Interval::rightOpen());
    }

    public function test_since_with_date_after_datetime() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Backward DateTimeIterator 2020-01-01 01:00:00+00:00...2019-12-01 00:00:00+00:00 requires negative TimeUnit');

        DateTime::fromString('2019-12-01 00:00:00+00')
            ->since(DateTime::fromString('2020-01-01 01:00:00+00'))
            ->iterate(TimeUnit::day(), Interval::rightOpen());
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

    public function test_since() : void
    {
        $this->assertSame(
            1,
            DateTime::fromString('2020-01-01 01:00:00+00')
                ->since(DateTime::fromString('2020-01-01 00:00:00+00'))
                ->distance()
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
     * @dataProvider ambiguous_time_data_provider
     */
    public function test_checking_is_ambiguous(DateTime $dateTime) : void
    {
        $this->assertTrue($dateTime->isAmbiguous(), $dateTime->toISO8601() . ' is not ambiguous, timezonedb version: ' . \timezone_version_get());
    }

    /**
     * @return \Generator<int, array{DateTime}, mixed, void>
     */
    public function ambiguous_time_data_provider() : \Generator
    {
        // yield [DateTime::fromString('2020-10-25 02:00:00 Europe/Warsaw')]; TODO: verify why this is failing only at CI, at PHP 8.1.8
        yield [DateTime::fromString('2020-10-25 02:30:30 Europe/Warsaw')];
        yield [DateTime::fromString('2020-10-25 02:59:59 Europe/Warsaw')];
        yield [DateTime::fromString('2020-10-25 03:00:00 Europe/Warsaw')];
    }

    /**
     * @dataProvider not_ambiguous_time_data_provider
     */
    public function test_checking_is_not_ambiguous(DateTime $dateTime) : void
    {
        $this->assertFalse($dateTime->isAmbiguous());
    }

    /**
     * @return \Generator<int, array{DateTime}, mixed, void>
     */
    public function not_ambiguous_time_data_provider() : \Generator
    {
        yield [new DateTime(Day::fromString('2020-01-01'), Time::fromString('00:00:00'), TimeZone::UTC())];
        yield [DateTime::fromString('2020-10-25 01:59:59 UTC')];
        yield [DateTime::fromString('2020-10-25 00:00:00 Europe/Warsaw')];
        yield [DateTime::fromString('2020-10-25 01:00:00 Europe/Warsaw')];
        yield [DateTime::fromString('2020-10-25 01:59:59 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 01:59:58 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 01:59:59 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 02:00:00 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 02:59:59 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 03:00:00 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 03:01:00 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 04:00:00 Europe/Warsaw')];
        yield [DateTime::fromString('2020-03-29 05:00:00 Europe/Warsaw')];
    }

    public function test_using_create_constructor_during_dst_gap() : void
    {
        $this->assertSame(
            '02:30:00.000000',
            DateTime::create(2020, 03, 29, 02, 30, 00, 0, 'Europe/Warsaw')->time()->toString()
        );
    }

    public function test_using_constructor_during_dst_gap() : void
    {
        $this->assertSame(
            '02:30:00.000000',
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

    public function test_time_zone_when_only_time_offset_explicitly_provided() : void
    {
        $this->assertSame('+01:00', DateTime::fromString('2020-01-01 00:00:00+0100')->timeZone()->name());
    }

    public function test_yesterday() : void
    {
        $this->assertSame('2019-12-31T00:00:00+00:00', DateTime::fromString('2020-01-01 01:00:00')->yesterday()->toISO8601());
    }

    public function test_yesterday_with_tz() : void
    {
        $this->assertSame('2019-12-31T00:00:00+01:00', DateTime::fromString('2020-01-01 01:00:00 Europe/Warsaw')->yesterday()->toISO8601());
    }

    public function test_tomorrow() : void
    {
        $this->assertSame('2020-01-02T00:00:00+00:00', DateTime::fromString('2020-01-01 01:00:00')->tomorrow()->toISO8601());
    }

    public function test_tomorrow_with_tz() : void
    {
        $this->assertSame('2020-01-02T00:00:00+01:00', DateTime::fromString('2020-01-01 01:00:00 Europe/Warsaw')->tomorrow()->toISO8601());
    }

    public function test_set_time() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00.00000')->toTimeZone(TimeZone::europeWarsaw());
        $newDateTime = $dateTime->setTime(new Time(1, 1, 1, 1));

        $this->assertSame(
            '2020-01-01 01:01:01.000001+01:00',
            $newDateTime->format('Y-m-d H:i:s.uP')
        );
    }

    public function test_set_time_in() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00.00000 UTC');
        $newDateTime = $dateTime->setTimeIn(new Time(15, 0, 0, 0), TimeZone::americaNewYork());

        $this->assertSame(
            '2020-01-01 15:00:00.000000-05:00',
            $newDateTime->format('Y-m-d H:i:s.uP')
        );
    }

    public function test_set_day() : void
    {
        $dateTime = DateTime::fromString('2020-01-01 00:00:00.00000')->toTimeZone(TimeZone::europeWarsaw());
        $newDateTime = $dateTime->setDay(Day::fromString('2020-01-05'));

        $this->assertSame(
            '2020-01-05 01:00:00.000000+01:00',
            $newDateTime->format('Y-m-d H:i:s.uP')
        );
    }

    public function test_distance_to() : void
    {
        $this->assertSame(58, DateTime::fromString('2020-01-01 01:00:00 UTC')->distance(DateTime::fromString('2020-01-03 12:00:00 Europe/Warsaw'))->inHours());
    }

    public function test_quarter() : void
    {
        $this->assertSame(1, DateTime::fromString('2020-01-01 00:00:00')->quarter()->number());
        $this->assertSame(2, DateTime::fromString('2020-04-01 00:00:00')->quarter()->number());
        $this->assertSame(3, DateTime::fromString('2020-07-01 00:00:00')->quarter()->number());
        $this->assertSame(4, DateTime::fromString('2020-10-01 00:00:00')->quarter()->number());
    }

    public function test_serialization() : void
    {
        $dateTime = DateTime::create(2020, 03, 29, 02, 30, 00, 0, 'Europe/Warsaw');

        $this->assertObjectEquals(
            $dateTime,
            \unserialize(\serialize($dateTime)),
            'isEqual'
        );
    }

    /**
     * @dataProvider timezone_abbreviation_provider
     */
    public function test_timezone_abbreviation(string $abbreviation, string $date) : void
    {
        $this->assertSame($abbreviation, DateTime::fromString($date)->timeZoneAbbreviation()->name());
    }

    /**
     * @return \Generator<int, array{string, string}, mixed, void>
     */
    public function timezone_abbreviation_provider() : \Generator
    {
        yield ['PST', '2021-01-01 00:00:00 America/Los_Angeles'];
        yield ['PDT', '2021-07-01 00:00:00 America/Los_Angeles'];
        yield ['CEST', '2021-07-01 00:00:00 Europe/Warsaw'];
        yield ['CET', '2021-01-01 00:00:00 Europe/Warsaw'];
        yield ['CEST', '2021-01-01 00:00:00 CEST'];
    }

    public function test_timezone_abbreviation_from_time_offset() : void
    {
        $this->expectException(Exception::class);

        DateTime::fromString('2020-01-01 00:00:00+01:00')->timeZoneAbbreviation();
    }

    public function test_from_date_time_immutable() : void
    {
        $this->assertSame('2020-01-01 00:00:00', DateTime::fromDateTime(new \DateTimeImmutable('2020-01-01 00:00:00'))->format('Y-m-d H:i:s'));
    }

    public function test_from_date_time() : void
    {
        $this->assertSame('2020-01-01 00:00:00', DateTime::fromDateTime(new \DateTime('2020-01-01 00:00:00'))->format('Y-m-d H:i:s'));
    }

    public function test_equals_works() : void
    {
        $this->assertEquals(
            DateTime::fromDateTime(new \DateTimeImmutable('2022-01-01 15:00:00')),
            DateTime::fromString('2022-01-01 15:00:00')
        );

        $this->assertEquals(
            DateTime::fromDateTime(new \DateTimeImmutable('2022-01-01 15:00:00')),
            new DateTime(
                new Day(
                    new Month(
                        new Year(2022),
                        1
                    ),
                    1
                ),
                new Time(15, 0, 0),
                TimeZone::UTC()
            )
        );
    }

    /**
     * @dataProvider compare_to_provider
     */
    public function test_compare_to(DateTime $dateTime, DateTime $comparable, int $compareResult) : void
    {
        $this->assertSame($compareResult, $dateTime->compareTo($comparable));
    }

    /**
     * @return \Generator<int, array{DateTime, DateTime, int}>
     */
    public function compare_to_provider() : \Generator
    {
        yield [DateTime::fromString('2022-10-26 11:53:12'), DateTime::fromString('2022-10-26 11:53:12'), 0];
        yield [DateTime::fromString('2022-10-26'), DateTime::fromString('2022-10-26'), 0];

        yield [DateTime::fromString('2022-10-25 11:53:12'), DateTime::fromString('2022-10-26 11:53:12'), -1];
        yield [DateTime::fromString('2022-10-25 11:53:12'), DateTime::fromString('2022-11-26 11:53:12'), -1];

        yield [DateTime::fromString('2022-10-25 11:53:12'), DateTime::fromString('2022-10-25 00:53:12'), 1];
        yield [DateTime::fromString('2022-11-26 11:53:12'), DateTime::fromString('2022-10-26 11:53:12'), 1];
    }
}
