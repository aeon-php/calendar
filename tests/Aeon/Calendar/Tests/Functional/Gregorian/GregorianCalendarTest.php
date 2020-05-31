<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Functional\Gregorian;

use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\TimeInterval;
use Aeon\Calendar\Gregorian\TimeZone;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class GregorianCalendarTest extends TestCase
{
    public function test_creating_calendar_with_system_default_tz() : void
    {
        $timezone = (GregorianCalendar::systemDefault())->now()->timeZone();

        $this->assertSame(
            \date_default_timezone_get(),
            $timezone instanceof TimeZone
                ? $timezone->name()
                : null
        );
    }

    public function test_current_date() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable())->format('Y-m-d'),
            (GregorianCalendar::UTC())->currentDay()->toDateTimeImmutable()->format('Y-m-d')
        );
    }

    public function test_current_year() : void
    {
        $this->assertSame(
            (int) (new \DateTimeImmutable())->format('Y'),
            (GregorianCalendar::UTC())->currentYear()->number()
        );
    }

    public function test_current_month() : void
    {
        $this->assertSame(
            (int) (new \DateTimeImmutable())->format('m'),
            (GregorianCalendar::UTC())->currentMonth()->number()
        );
    }

    public function test_yesterday() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('yesterday'))->format('Y-m-d'),
            GregorianCalendar::UTC()->yesterday()->format('Y-m-d')
        );
    }

    public function test_tomorrow() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('tomorrow'))->format('Y-m-d'),
            (GregorianCalendar::UTC())->tomorrow()->format('Y-m-d')
        );
    }

    public function test_today_midnight() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('midnight'))->format('Y-m-d 00:00:00'),
            (GregorianCalendar::UTC())->now()->midnight()->format('Y-m-d H:i:s')
        );
    }

    public function test_today_noon() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('midnight'))->format('Y-m-d 12:00:00'),
            (GregorianCalendar::UTC())->now()->noon()->format('Y-m-d H:i:s')
        );
    }

    public function test_today_end_of_day() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('midnight'))->format('Y-m-d 23:59:59'),
            (GregorianCalendar::UTC())->now()->endOfDay()->format('Y-m-d H:i:s')
        );
    }

    public function test_iterating_overt_time() : void
    {
        $intervals = ($calendar = GregorianCalendar::UTC())
            ->yesterday()
            ->to($calendar->tomorrow())
            ->iterate(TimeUnit::hour())
            ->map(function (TimeInterval $interval) use (&$iterations) {
                return $interval->startDateTime()->toDateTimeImmutable()->format('Y-m-d H:i:s');
            });

        $this->assertCount(48, $intervals);

        $this->assertSame(
            (new \DateTimeImmutable('yesterday midnight'))->format('Y-m-d H:i:s'),
            $intervals[0]
        );

        $this->assertSame(
            (new \DateTimeImmutable('tomorrow midnight'))->modify('-1 hour')->format('Y-m-d H:i:s'),
            $intervals[47]
        );
    }

    public function test_iterating_overt_time_and_taking_every_second_hour() : void
    {
        $intervals = ($calendar = GregorianCalendar::UTC())
            ->yesterday()
            ->to($calendar->tomorrow())
            ->iterate(TimeUnit::hour())
            ->filter(function (TimeInterval $interval) use (&$iterations) : bool {
                return $interval->startDateTime()->time()->hour() % 2 === 0;
            });

        $this->assertCount(24, $intervals);
    }

    public function test_iterating_overt_time_backward() : void
    {
        $intervals = ($calendar = GregorianCalendar::UTC())
            ->yesterday()
            ->to($calendar->tomorrow())
            ->iterateBackward(TimeUnit::hour())
            ->map(function (TimeInterval $interval) {
                return $interval->startDateTime()->toDateTimeImmutable()->format('Y-m-d H:i:s');
            });

        $this->assertCount(48, $intervals);

        $this->assertSame(
            (new \DateTimeImmutable('tomorrow midnight'))->format('Y-m-d H:i:s'),
            $intervals[0]
        );

        $this->assertSame(
            (new \DateTimeImmutable('yesterday midnight'))->modify('+1 hour')->format('Y-m-d H:i:s'),
            $intervals[47]
        );
    }
}
