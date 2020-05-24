<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit\Gregorian;

use Ocelot\Ocelot\Calendar\Gregorian\DateTime;
use Ocelot\Ocelot\Calendar\Gregorian\Day;
use Ocelot\Ocelot\Calendar\Gregorian\Time;
use Ocelot\Ocelot\Calendar\Gregorian\TimeInterval;
use Ocelot\Ocelot\Calendar\Gregorian\TimeUnit;
use Ocelot\Ocelot\Calendar\Gregorian\TimeZone;
use Ocelot\Ocelot\Calendar\Gregorian\TimeZone\TimeOffset;
use PHPUnit\Framework\TestCase;

final class DateTimeTest extends TestCase
{
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
        $dateTime = DateTime::fromString('2020-01-01 12:54:23.000001');

        $this->assertSame(12, $dateTime->time()->hour());
        $this->assertSame(54, $dateTime->time()->minute());
        $this->assertSame(23, $dateTime->time()->second());
        $this->assertSame(1, $dateTime->time()->microsecond());
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
            ->toTimeZone(new TimeZone('Europe/Warsaw'));;

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
}