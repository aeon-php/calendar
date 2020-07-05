<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Functional\Gregorian;

use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\TimePeriod;
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

    public function test_today_midnight_with_custom_tz() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('midnight', new \DateTimeZone('Europe/Warsaw')))->format('c'),
            (new GregorianCalendar(TimeZone::europeWarsaw()))->now()->midnight()->format('c')
        );
    }

    public function test_today_noon() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('noon'))->format('Y-m-d 12:00:00'),
            (GregorianCalendar::UTC())->now()->noon()->format('Y-m-d H:i:s')
        );
    }

    public function test_today_noon_with_custom_tz() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('noon', new \DateTimeZone('Europe/Warsaw')))->format('c'),
            (new GregorianCalendar(TimeZone::europeWarsaw()))->now()->noon()->format('c')
        );
    }

    public function test_today_end_of_day() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('midnight'))->format('Y-m-d 23:59:59'),
            (GregorianCalendar::UTC())->now()->endOfDay()->format('Y-m-d H:i:s')
        );
    }

    public function test_today_end_of_day_with_custom_tz() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('tomorrow midnight', new \DateTimeZone('Europe/Warsaw')))->sub(new \DateInterval('PT1S'))->format('c'),
            (new GregorianCalendar(TimeZone::europeWarsaw()))->now()->endOfDay()->format('c')
        );
    }

    public function test_iterating_overt_time() : void
    {
        $timePeriods = ($calendar = GregorianCalendar::UTC())
            ->yesterday()
            ->midnight()
            ->until($calendar->tomorrow()->midnight())
            ->iterate(TimeUnit::hour())
            ->map(function (TimePeriod $timePeriod) use (&$iterations) {
                return $timePeriod->start()->toDateTimeImmutable()->format('Y-m-d H:i:s');
            });

        $this->assertCount(48, $timePeriods);

        $this->assertSame(
            (new \DateTimeImmutable('yesterday midnight'))->format('Y-m-d H:i:s'),
            $timePeriods[0]
        );

        $this->assertSame(
            (new \DateTimeImmutable('tomorrow midnight'))->modify('-1 hour')->format('Y-m-d H:i:s'),
            $timePeriods[47]
        );
    }

    public function test_iterating_overt_time_and_taking_every_second_hour() : void
    {
        $timePeriods = ($calendar = GregorianCalendar::UTC())
            ->yesterday()
            ->midnight()
            ->until($calendar->tomorrow()->midnight())
            ->iterate(TimeUnit::hour())
            ->filter(function (TimePeriod $timePeriod) use (&$iterations) : bool {
                return $timePeriod->start()->time()->hour() % 2 === 0;
            });

        $this->assertCount(24, $timePeriods);
    }

    public function test_iterating_overt_time_backward() : void
    {
        $timePeriods = ($calendar = GregorianCalendar::UTC())
            ->yesterday()
            ->midnight()
            ->until($calendar->tomorrow()->midnight())
            ->iterateBackward(TimeUnit::hour())
            ->map(function (TimePeriod $interval) {
                return $interval->start()->toDateTimeImmutable()->format('Y-m-d H:i:s');
            });

        $this->assertCount(48, $timePeriods);

        $this->assertSame(
            (new \DateTimeImmutable('tomorrow midnight'))->format('Y-m-d H:i:s'),
            $timePeriods[0]
        );

        $this->assertSame(
            (new \DateTimeImmutable('yesterday midnight'))->modify('+1 hour')->format('Y-m-d H:i:s'),
            $timePeriods[47]
        );
    }
}
