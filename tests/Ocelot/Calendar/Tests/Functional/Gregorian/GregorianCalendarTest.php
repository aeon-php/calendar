<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Functional\Gregorian;

use Ocelot\Calendar\Gregorian\TimeInterval;
use Ocelot\Calendar\Gregorian\TimeUnit;
use Ocelot\Calendar\Gregorian\GregorianCalendar;
use PHPUnit\Framework\TestCase;

final class GregorianCalendarTest extends TestCase
{
    public function test_current_date() : void
    {
        $this->assertSame(
            (new \DateTimeImmutable())->format('Y-m-d'),
            (GregorianCalendar::UTC())->day()->toDateTimeImmutable()->format('Y-m-d')
        );
    }

    public function test_yesterday () : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('yesterday'))->format('Y-m-d'),
            GregorianCalendar::UTC()->yesterday()->format('Y-m-d')
        );
    }

    public function test_tomorrow () : void
    {
        $this->assertSame(
            (new \DateTimeImmutable('tomorrow'))->format('Y-m-d'),
            (GregorianCalendar::UTC())->tomorrow()->format('Y-m-d')
        );
    }

    public function test_today_midnight () : void
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
            ->map(function(TimeInterval $interval) use (&$iterations) {
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

    public function test_iterating_overt_time_backward() : void
    {
        $intervals = ($calendar = GregorianCalendar::UTC())
            ->yesterday()
            ->to($calendar->tomorrow())
            ->iterateBackward(TimeUnit::hour())
            ->map(function(TimeInterval $interval) {
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