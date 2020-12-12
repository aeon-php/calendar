<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\RelativeTimeUnit;
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

    public function test_distance_in_time_unit_before_and_after_unix_epoch() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('1969-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-01 00:00:00.0000')
        );

        $this->assertSame(1609372800, $period->distance()->inSeconds());
        $this->assertFalse($period->distance()->isNegative());
    }

    public function test_distance_in_time_unit_before_and_after_unix_epoch_inverse() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('1969-01-01 00:00:00.0000')
        );

        $this->assertSame(-1609372800, $period->distance()->inSeconds());
        $this->assertTrue($period->distance()->isNegative());
    }

    public function test_distance_in_time_unit_before_and_before_unix_epoch() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('1969-01-01 00:00:00.0000'),
            DateTime::fromString('1969-01-01 01:00:00.0000')
        );

        $this->assertSame(3600, $period->distance()->inSeconds());
        $this->assertFalse($period->distance()->isNegative());
    }

    public function test_distance_in_time_unit_before_and_before_unix_epoch_inverse() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('1969-01-01 01:00:00.0000'),
            DateTime::fromString('1969-01-01 00:00:00.0000')
        );

        $this->assertSame(-3600, $period->distance()->inSeconds());
        $this->assertTrue($period->distance()->isNegative());
    }

    public function test_precise_distance_in_time_unit_from_start_to_end() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 12:25:30.079635'),
            DateTime::fromString('2020-01-01 12:25:32.588460')
        );

        $this->assertSame('2.508825', $period->distance()->inSecondsPrecise());
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

    public function test_iterating_through_day_by_hour() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::hour(), Interval::rightOpen());

        $this->assertCount(24, $timePeriods);

        $this->assertInstanceOf(TimePeriod::class, $timePeriods[0]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods[1]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods[2]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods[23]);

        $this->assertSame(0, $timePeriods[0]->start()->time()->hour());
        $this->assertSame(1, $timePeriods[0]->end()->time()->hour());
        $this->assertSame(1, $timePeriods[1]->start()->time()->hour());
        $this->assertSame(2, $timePeriods[1]->end()->time()->hour());
        $this->assertSame(2, $timePeriods[2]->start()->time()->hour());
        $this->assertSame(3, $timePeriods[2]->end()->time()->hour());
        $this->assertSame(23, $timePeriods[23]->start()->time()->hour());
        $this->assertSame(0, $timePeriods[23]->end()->time()->hour());
    }

    public function test_iterating_through_day_backward_by_hour() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timePeriods = $period->iterateBackward(TimeUnit::hour(), Interval::leftOpen());

        $this->assertCount(24, $timePeriods);

        $this->assertInstanceOf(TimePeriod::class, $timePeriods[0]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods[1]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods[2]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods[23]);

        $this->assertSame(0, $timePeriods[0]->start()->time()->hour());
        $this->assertSame(23, $timePeriods[0]->end()->time()->hour());
        $this->assertSame(23, $timePeriods[1]->start()->time()->hour());
        $this->assertSame(22, $timePeriods[1]->end()->time()->hour());
        $this->assertSame(22, $timePeriods[2]->start()->time()->hour());
        $this->assertSame(21, $timePeriods[2]->end()->time()->hour());
        $this->assertSame(1, $timePeriods[23]->start()->time()->hour());
        $this->assertSame(0, $timePeriods[23]->end()->time()->hour());
    }

    public function test_iterating_by_days_interval_closed_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::day(), Interval::closed());
        $timePeriodsBackward = $period->iterateBackward(TimeUnit::day(), Interval::closed());

        $this->assertCount(5, $timePeriods);
        $this->assertCount(5, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriods[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods[3]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-05', $timePeriods[4]->start()->format('Y-m-d'));

        $this->assertSame('2020-01-05', $timePeriodsBackward[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriodsBackward[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward[3]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward[4]->start()->format('Y-m-d'));
    }

    public function test_iterating_by_days_interval_left_open_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::day(), Interval::leftOpen());
        $timePeriodsBackward = $period->iterateBackward(TimeUnit::day(), Interval::leftOpen());

        $this->assertCount(4, $timePeriods);
        $this->assertCount(4, $timePeriodsBackward);

        $this->assertSame('2020-01-02', $timePeriods[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-05', $timePeriods[3]->start()->format('Y-m-d'));

        $this->assertSame('2020-01-05', $timePeriodsBackward[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriodsBackward[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward[3]->start()->format('Y-m-d'));
    }

    public function test_iterating_by_days_interval_right_open_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::day(), Interval::rightOpen());
        $timePeriodsBackward = $period->iterateBackward(TimeUnit::day(), Interval::rightOpen());

        $this->assertCount(4, $timePeriods);
        $this->assertCount(4, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriods[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods[3]->start()->format('Y-m-d'));

        $this->assertSame('2020-01-04', $timePeriodsBackward[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward[3]->start()->format('Y-m-d'));
    }

    public function test_iterating_by_days_interval_open_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::day(), Interval::open());
        $timePeriodsBackward = $period->iterateBackward(TimeUnit::day(), Interval::open());

        $this->assertCount(3, $timePeriods);
        $this->assertCount(3, $timePeriodsBackward);

        $this->assertSame('2020-01-02', $timePeriods[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods[2]->start()->format('Y-m-d'));

        $this->assertSame('2020-01-04', $timePeriodsBackward[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward[2]->start()->format('Y-m-d'));
    }

    public function test_iterating_by_month_interval_closed_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2021-01-01 00:00:00.0000')
        );

        $timePeriods = $period->iterate(RelativeTimeUnit::month(), Interval::closed());
        $timePeriodsBackward = $period->iterateBackward(RelativeTimeUnit::month(), Interval::closed());

        $this->assertCount(13, $timePeriods);
        $this->assertCount(13, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods[0]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[0]->distance()->inDays());
        $this->assertSame('2020-02-01', $timePeriods[1]->start()->format('Y-m-d'));
        $this->assertSame(29, $timePeriods[1]->distance()->inDays());
        $this->assertSame('2020-03-01', $timePeriods[2]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[2]->distance()->inDays());
        $this->assertSame('2020-04-01', $timePeriods[3]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods[3]->distance()->inDays());
        $this->assertSame('2020-05-01', $timePeriods[4]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[4]->distance()->inDays());
        $this->assertSame('2020-06-01', $timePeriods[5]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods[5]->distance()->inDays());
        $this->assertSame('2020-07-01', $timePeriods[6]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[6]->distance()->inDays());
        $this->assertSame('2020-08-01', $timePeriods[7]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[7]->distance()->inDays());
        $this->assertSame('2020-09-01', $timePeriods[8]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods[8]->distance()->inDays());
        $this->assertSame('2020-10-01', $timePeriods[9]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[9]->distance()->inDays());
        $this->assertSame('2020-11-01', $timePeriods[10]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods[10]->distance()->inDays());
        $this->assertSame('2020-12-01', $timePeriods[11]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[11]->distance()->inDays());
        $this->assertSame('2021-01-01', $timePeriods[12]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods[12]->distance()->inDays());

        $this->assertSame('2021-01-01', $timePeriodsBackward[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-12-01', $timePeriodsBackward[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-11-01', $timePeriodsBackward[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-10-01', $timePeriodsBackward[3]->start()->format('Y-m-d'));
        $this->assertSame('2020-09-01', $timePeriodsBackward[4]->start()->format('Y-m-d'));
        $this->assertSame('2020-08-01', $timePeriodsBackward[5]->start()->format('Y-m-d'));
        $this->assertSame('2020-07-01', $timePeriodsBackward[6]->start()->format('Y-m-d'));
        $this->assertSame('2020-06-01', $timePeriodsBackward[7]->start()->format('Y-m-d'));
        $this->assertSame('2020-05-01', $timePeriodsBackward[8]->start()->format('Y-m-d'));
        $this->assertSame('2020-04-01', $timePeriodsBackward[9]->start()->format('Y-m-d'));
        $this->assertSame('2020-03-01', $timePeriodsBackward[10]->start()->format('Y-m-d'));
        $this->assertSame('2020-02-01', $timePeriodsBackward[11]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward[12]->start()->format('Y-m-d'));
    }

    public function test_iterating_by_year_interval_closed_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2025-01-01 00:00:00.0000')
        );

        $timePeriods = $period->iterate(RelativeTimeUnit::year(), Interval::closed());
        $timePeriodsBackward = $period->iterateBackward(RelativeTimeUnit::year(), Interval::closed());

        $this->assertCount(6, $timePeriods);
        $this->assertCount(6, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods[0]->start()->format('Y-m-d'));
        $this->assertSame('2021-01-01', $timePeriods[1]->start()->format('Y-m-d'));
        $this->assertSame('2022-01-01', $timePeriods[2]->start()->format('Y-m-d'));
        $this->assertSame('2023-01-01', $timePeriods[3]->start()->format('Y-m-d'));
        $this->assertSame('2024-01-01', $timePeriods[4]->start()->format('Y-m-d'));
        $this->assertSame('2025-01-01', $timePeriods[5]->start()->format('Y-m-d'));

        $this->assertSame('2025-01-01', $timePeriodsBackward[0]->start()->format('Y-m-d'));
        $this->assertSame('2024-01-01', $timePeriodsBackward[1]->start()->format('Y-m-d'));
        $this->assertSame('2023-01-01', $timePeriodsBackward[2]->start()->format('Y-m-d'));
        $this->assertSame('2022-01-01', $timePeriodsBackward[3]->start()->format('Y-m-d'));
        $this->assertSame('2021-01-01', $timePeriodsBackward[4]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward[5]->start()->format('Y-m-d'));
    }

    public function test_iterating_through_day_by_2_days() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::days(2), Interval::closed());

        $this->assertCount(2, $timePeriods);
    }

    public function test_iterating_through_day_backward_by_2_days() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timePeriods = $period->iterateBackward(TimeUnit::days(2), Interval::closed());

        $this->assertCount(2, $timePeriods);
    }

    /**
     * @dataProvider overlapping_time_periods_data_provider
     */
    public function test_overlapping_time_periods(bool $overlap, TimePeriod $firstPeriod, TimePeriod $secondPeriod) : void
    {
        $this->assertSame($overlap, $firstPeriod->overlaps($secondPeriod));
    }

    /**
     * @return \Generator<int, array{bool, TimePeriod, TimePeriod}, mixed, void>
     */
    public function overlapping_time_periods_data_provider() : \Generator
    {
        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-05-02 00:00:00.0000'), DateTime::fromString('2020-05-03 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-01 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-05-02 00:00:00.0000'), DateTime::fromString('2020-05-03 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-05-03 00:00:00.0000'), DateTime::fromString('2020-05-02 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-01 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-04 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-01 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-04 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-04 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-04 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-10 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-07 00:00:00.0000'), DateTime::fromString('2020-01-10 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.0000'), DateTime::fromString('2020-01-07 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-10 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.0000'), DateTime::fromString('2020-01-01 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.0000'), DateTime::fromString('2020-01-08 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-08 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-04 00:00:00.0000'), DateTime::fromString('2020-01-13 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-08 00:00:00.0000')),
        ];
    }

    public function test_period_is_forward() : void
    {
        $this->assertTrue(
            (new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')))
                ->isForward()
        );
        $this->assertFalse(
            (new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')))
                ->isBackward()
        );
    }

    public function test_period_is_backward() : void
    {
        $this->assertTrue(
            (new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-01 00:00:00.0000')))
                ->isBackward()
        );
        $this->assertFalse(
            (new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-01 00:00:00.0000')))
                ->isForward()
        );
    }

    /**
     * @dataProvider period_abuts_other_period_data_provider
     */
    public function test_period_abuts_other_period(bool $abuts, TimePeriod $firstPeriod, TimePeriod $secondPeriod) : void
    {
        $this->assertSame($abuts, $firstPeriod->abuts($secondPeriod));
    }

    /**
     * @return \Generator<int, array{bool, TimePeriod, TimePeriod}, mixed, void>
     */
    public function period_abuts_other_period_data_provider() : \Generator
    {
        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.0000'), DateTime::fromString('2020-01-02 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-04 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.0000'), DateTime::fromString('2020-01-04 00:00:00.0000')),
        ];

        yield [
            true,
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.0000'), DateTime::fromString('2020-01-04 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-04 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-04 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
        ];

        yield [
            false,
            new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.0000'), DateTime::fromString('2020-01-03 00:00:00.0000')),
            new TimePeriod(DateTime::fromString('2020-01-04 00:00:00.0000'), DateTime::fromString('2020-01-05 00:00:00.0000')),
        ];
    }

    public function test_one_period_contains_the_same_period() : void
    {
        $this->assertTrue(
            (new TimePeriod(DateTime::fromString('2020-01-01'), DateTime::fromString('2020-01-02')))
                ->contains(new TimePeriod(DateTime::fromString('2020-01-01'), DateTime::fromString('2020-01-02')))
        );
    }

    public function test_one_period_contains_shorted_period() : void
    {
        $this->assertTrue(
            (new TimePeriod(DateTime::fromString('2020-01-01'), DateTime::fromString('2020-01-05')))
                ->contains(new TimePeriod(DateTime::fromString('2020-01-02'), DateTime::fromString('2020-01-03')))
        );
    }

    public function test_one_period_not_contains_other_overlapping_period() : void
    {
        $this->assertFalse(
            (new TimePeriod(DateTime::fromString('2020-01-05'), DateTime::fromString('2020-01-10')))
                ->contains(new TimePeriod(DateTime::fromString('2020-01-02'), DateTime::fromString('2020-01-07')))
        );
    }

    public function test_merge_not_overlapping_time_periods() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Can't merge not overlapping time periods");

        (new TimePeriod(DateTime::fromString('2020-01-05'), DateTime::fromString('2020-01-10')))
            ->merge(new TimePeriod(DateTime::fromString('2020-01-20'), DateTime::fromString('2020-01-25')));
    }

    public function test_merge_left_overlapping_time_periods() : void
    {
        $newPeriod = (new TimePeriod(DateTime::fromString('2020-01-05'), DateTime::fromString('2020-01-10')))
            ->merge(new TimePeriod(DateTime::fromString('2020-01-08'), DateTime::fromString('2020-01-25')));

        $this->assertSame(
            '2020-01-05',
            $newPeriod->start()->format('Y-m-d')
        );

        $this->assertSame(
            '2020-01-25',
            $newPeriod->end()->format('Y-m-d')
        );
    }

    public function test_merge_right_overlapping_time_periods() : void
    {
        $newPeriod = (new TimePeriod(DateTime::fromString('2020-01-10'), DateTime::fromString('2020-02-10')))
            ->merge(new TimePeriod(DateTime::fromString('2020-01-08'), DateTime::fromString('2020-01-25')));

        $this->assertSame(
            '2020-01-08',
            $newPeriod->start()->format('Y-m-d')
        );

        $this->assertSame(
            '2020-02-10',
            $newPeriod->end()->format('Y-m-d')
        );
    }

    public function test_serialization() : void
    {
        $timePeriod = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00'),
            DateTime::fromString('2020-01-02 00:00:00')
        );

        $this->assertSame(
            [
                'start' => $timePeriod->start(),
                'end' => $timePeriod->end(),
            ],
            $timePeriod->__serialize()
        );
        $this->assertSame(
            'O:34:"Aeon\Calendar\Gregorian\TimePeriod":2:{s:5:"start";O:32:"Aeon\Calendar\Gregorian\DateTime":4:{s:3:"day";O:27:"Aeon\Calendar\Gregorian\Day":2:{s:5:"month";O:29:"Aeon\Calendar\Gregorian\Month":2:{s:4:"year";O:28:"Aeon\Calendar\Gregorian\Year":1:{s:4:"year";i:2020;}s:6:"number";i:1;}s:6:"number";i:1;}s:4:"time";O:28:"Aeon\Calendar\Gregorian\Time":4:{s:4:"hour";i:0;s:6:"minute";i:0;s:6:"second";i:0;s:11:"microsecond";i:0;}s:8:"timeZone";O:32:"Aeon\Calendar\Gregorian\TimeZone":1:{s:4:"name";s:3:"UTC";}s:10:"timeOffset";O:43:"Aeon\Calendar\Gregorian\TimeZone\TimeOffset":3:{s:5:"hours";i:0;s:7:"minutes";i:0;s:8:"negative";b:0;}}s:3:"end";O:32:"Aeon\Calendar\Gregorian\DateTime":4:{s:3:"day";O:27:"Aeon\Calendar\Gregorian\Day":2:{s:5:"month";O:29:"Aeon\Calendar\Gregorian\Month":2:{s:4:"year";O:28:"Aeon\Calendar\Gregorian\Year":1:{s:4:"year";i:2020;}s:6:"number";i:1;}s:6:"number";i:2;}s:4:"time";O:28:"Aeon\Calendar\Gregorian\Time":4:{s:4:"hour";i:0;s:6:"minute";i:0;s:6:"second";i:0;s:11:"microsecond";i:0;}s:8:"timeZone";O:32:"Aeon\Calendar\Gregorian\TimeZone":1:{s:4:"name";s:3:"UTC";}s:10:"timeOffset";O:43:"Aeon\Calendar\Gregorian\TimeZone\TimeOffset":3:{s:5:"hours";i:0;s:7:"minutes";i:0;s:8:"negative";b:0;}}}',
            \serialize($timePeriod)
        );
    }
}
