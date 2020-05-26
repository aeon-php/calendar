<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\TimeInterval;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimePeriodTest extends TestCase
{
    public function test_distance_in_time_unit_from_start_to_end_date() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $this->assertSame(86400, $period->distance()->inSeconds());
        $this->assertFalse($period->distance()->isNegative());
    }

    public function test_distance_in_time_unit_from_start_to_end_date_between_years() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2021-01-01 00:00:00.0000')
        );

        $this->assertSame(DateTime::fromString('2020-01-01 00:00:00.0000')->year()->numberOfDays(), $period->distance()->inDays());
        $this->assertFalse($period->distance()->isNegative());
        $this->assertTrue(DateTime::fromString('2020-01-01 00:00:00.0000')->year()->isLeap());
    }

    public function test_distance_in_time_unit_from_end_to_start_date() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $this->assertSame(-86400, $period->distanceBackward()->inSeconds());
        $this->assertSame(86400, $period->distanceBackward()->inSecondsAbs());
        $this->assertTrue($period->distanceBackward()->isNegative());
    }

    public function test_iterating_through_day_by_hour() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timeIntervals = $period->iterate(TimeUnit::hour());

        $this->assertCount(24, $timeIntervals);

        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[0]);
        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[1]);
        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[2]);
        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[23]);

        $this->assertSame(0, $timeIntervals[0]->startDateTime()->time()->hour());
        $this->assertSame(1, $timeIntervals[0]->endDateTime()->time()->hour());
        $this->assertSame(1, $timeIntervals[1]->startDateTime()->time()->hour());
        $this->assertSame(2, $timeIntervals[1]->endDateTime()->time()->hour());
        $this->assertSame(2, $timeIntervals[2]->startDateTime()->time()->hour());
        $this->assertSame(3, $timeIntervals[2]->endDateTime()->time()->hour());
        $this->assertSame(23, $timeIntervals[23]->startDateTime()->time()->hour());
        $this->assertSame(0, $timeIntervals[23]->endDateTime()->time()->hour());
    }

    public function test_iterating_through_day_backward_by_hour() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timeIntervals = $period->iterateBackward(TimeUnit::hour());

        $this->assertCount(24, $timeIntervals);

        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[0]);
        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[1]);
        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[2]);
        $this->assertInstanceOf(TimeInterval::class, $timeIntervals[23]);

        $this->assertSame(0, $timeIntervals[0]->startDateTime()->time()->hour());
        $this->assertSame(23, $timeIntervals[0]->endDateTime()->time()->hour());
        $this->assertSame(23, $timeIntervals[1]->startDateTime()->time()->hour());
        $this->assertSame(22, $timeIntervals[1]->endDateTime()->time()->hour());
        $this->assertSame(22, $timeIntervals[2]->startDateTime()->time()->hour());
        $this->assertSame(21, $timeIntervals[2]->endDateTime()->time()->hour());
        $this->assertSame(1, $timeIntervals[23]->startDateTime()->time()->hour());
        $this->assertSame(0, $timeIntervals[23]->endDateTime()->time()->hour());
    }

    public function test_iterating_through_day_by_2_days() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timeIntervals = $period->iterate(TimeUnit::days(2));

        $this->assertCount(1, $timeIntervals);
    }

    public function test_iterating_through_day_backward_by_2_days() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timeIntervals = $period->iterateBackward(TimeUnit::days(2));

        $this->assertCount(1, $timeIntervals);
    }
}