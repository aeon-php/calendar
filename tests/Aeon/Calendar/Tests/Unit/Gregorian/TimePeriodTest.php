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

    /**
     * @dataProvider iterating_through_intervals_provider
     */
    public function test_iterating_through_intervals(string $startDate, string $endDate, bool $forward, TimeUnit $timeUnit, Interval $interval, array $periods, string $format = 'Y-m-d') : void
    {
        $period = new TimePeriod(
            DateTime::fromString($startDate),
            DateTime::fromString($endDate)
        );

        $timePeriods = ($forward) ? $period->iterate($timeUnit, $interval) : $period->iterateBackward($timeUnit, $interval);

        $periodsResult = $timePeriods->map(fn (TimePeriod $timePeriod) : string => $timePeriod->start()->format($format) . '...' . $timePeriod->end()->format($format));

        $this->assertSame($periods, $periodsResult);
    }

    public function iterating_through_intervals_provider() : \Generator
    {
        yield ['2020-01-01', '2020-01-03', true, TimeUnit::day(), Interval::closed(), ['2020-01-01...2020-01-02', '2020-01-02...2020-01-03']];
        yield ['2020-01-01', '2020-01-03', true, TimeUnit::day(), Interval::open(), []];
        yield ['2020-01-01', '2020-01-03', true, TimeUnit::day(), Interval::leftOpen(), ['2020-01-02...2020-01-03']];
        yield ['2020-01-01', '2020-01-03', true, TimeUnit::day(), Interval::rightOpen(), ['2020-01-01...2020-01-02']];

        yield ['2020-01-01', '2020-01-06', true, TimeUnit::days(2), Interval::closed(), ['2020-01-01...2020-01-03', '2020-01-03...2020-01-05', '2020-01-05...2020-01-06']];
        yield ['2020-01-01', '2020-01-06', true, TimeUnit::days(2), Interval::open(), ['2020-01-03...2020-01-05']];
        yield ['2020-01-01', '2020-01-06', true, TimeUnit::days(2), Interval::leftOpen(), ['2020-01-03...2020-01-05', '2020-01-05...2020-01-06']];
        yield ['2020-01-01', '2020-01-06', true, TimeUnit::days(2), Interval::rightOpen(), ['2020-01-01...2020-01-03', '2020-01-03...2020-01-05']];

        yield ['2020-01-01', '2020-01-03', false, TimeUnit::day(), Interval::closed(), ['2020-01-03...2020-01-02', '2020-01-02...2020-01-01']];
        yield ['2020-01-01', '2020-01-03', false, TimeUnit::day(), Interval::open(), []];
        yield ['2020-01-01', '2020-01-03', false, TimeUnit::days(1), Interval::leftOpen(), ['2020-01-03...2020-01-02']];
        yield ['2020-01-01', '2020-01-03', false, TimeUnit::days(1), Interval::rightOpen(), ['2020-01-02...2020-01-01']];

        yield ['2020-01-01', '2020-01-06', false, TimeUnit::days(2), Interval::closed(), ['2020-01-06...2020-01-04', '2020-01-04...2020-01-02', '2020-01-02...2020-01-01']];
        yield ['2020-01-01', '2020-01-06', false, TimeUnit::days(2), Interval::open(), ['2020-01-04...2020-01-02']];
        yield ['2020-01-01', '2020-01-06', false, TimeUnit::days(2), Interval::leftOpen(), ['2020-01-06...2020-01-04', '2020-01-04...2020-01-02']];
        yield ['2020-01-01', '2020-01-06', false, TimeUnit::days(2), Interval::rightOpen(), ['2020-01-04...2020-01-02', '2020-01-02...2020-01-01']];
    }

    public function test_iterating_through_day_by_hour() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::hour(), Interval::rightOpen());

        $this->assertCount(23, $timePeriods);

        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[0]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[1]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[2]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[22]);

        $this->assertSame(0, $timePeriods->all()[0]->start()->time()->hour());
        $this->assertSame(1, $timePeriods->all()[0]->end()->time()->hour());
        $this->assertSame(1, $timePeriods->all()[1]->start()->time()->hour());
        $this->assertSame(2, $timePeriods->all()[1]->end()->time()->hour());
        $this->assertSame(2, $timePeriods->all()[2]->start()->time()->hour());
        $this->assertSame(3, $timePeriods->all()[2]->end()->time()->hour());
        $this->assertSame(22, $timePeriods->all()[22]->start()->time()->hour());
        $this->assertSame(23, $timePeriods->all()[22]->end()->time()->hour());
    }

    public function test_iterating_through_day_backward_by_hour() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timePeriods = $period->iterateBackward(TimeUnit::hour(), Interval::leftOpen());

        $this->assertCount(23, $timePeriods);

        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[0]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[1]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[2]);
        $this->assertInstanceOf(TimePeriod::class, $timePeriods->all()[22]);

        $this->assertSame(0, $timePeriods->all()[0]->start()->time()->hour());
        $this->assertSame(23, $timePeriods->all()[0]->end()->time()->hour());
        $this->assertSame(23, $timePeriods->all()[1]->start()->time()->hour());
        $this->assertSame(22, $timePeriods->all()[1]->end()->time()->hour());
        $this->assertSame(22, $timePeriods->all()[2]->start()->time()->hour());
        $this->assertSame(21, $timePeriods->all()[2]->end()->time()->hour());
        $this->assertSame(2, $timePeriods->all()[22]->start()->time()->hour());
        $this->assertSame(1, $timePeriods->all()[22]->end()->time()->hour());
    }

    public function test_iterating_by_2days_interval_closed_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::days(3), $interval = Interval::closed());
        $timePeriodsBackward = $period->iterateBackward(TimeUnit::days(3), Interval::closed());

        $this->assertTrue($interval->isClosed());
        $this->assertCount(2, $timePeriods);
        $this->assertCount(2, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-05', $timePeriods->all()[1]->end()->format('Y-m-d'));

        $this->assertSame('2020-01-05', $timePeriodsBackward->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward->all()[0]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward->all()[1]->end()->format('Y-m-d'));
    }

    public function test_iterating_by_day_interval_closed_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::day(), $interval = Interval::closed());
        $timePeriodsBackward = $period->iterateBackward(TimeUnit::day(), Interval::closed());

        $this->assertTrue($interval->isClosed());
        $this->assertCount(4, $timePeriods);
        $this->assertCount(4, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriods->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods->all()[3]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-05', $timePeriods->all()[3]->end()->format('Y-m-d'));

        $this->assertSame('2020-01-05', $timePeriodsBackward->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriodsBackward->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward->all()[3]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward->all()[3]->end()->format('Y-m-d'));
    }

    public function test_iterating_by_day_interval_left_open_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::day(), Interval::leftOpen());
        $timePeriodsBackward = $period->iterateBackward(TimeUnit::day(), Interval::leftOpen());

        $this->assertCount(3, $timePeriods);
        $this->assertCount(3, $timePeriodsBackward);

        $this->assertSame('2020-01-02', $timePeriods->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods->all()[0]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods->all()[1]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-05', $timePeriods->all()[2]->end()->format('Y-m-d'));

        $this->assertSame('2020-01-05', $timePeriodsBackward->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriodsBackward->all()[0]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriodsBackward->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward->all()[1]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward->all()[2]->end()->format('Y-m-d'));
    }

    public function test_iterating_by_day_interval_right_open_forward() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriods = $period->iterate(TimeUnit::day(), Interval::rightOpen());

        $this->assertCount(3, $timePeriods);

        $this->assertSame('2020-01-01', $timePeriods->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriods->all()[0]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriods->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods->all()[1]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriods->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-04', $timePeriods->all()[2]->end()->format('Y-m-d'));
    }

    public function test_iterating_by_day_interval_right_open_backward() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-05 00:00:00.0000')
        );

        $timePeriodsBackward = $period->iterateBackward(TimeUnit::day(), Interval::rightOpen());

        $this->assertCount(3, $timePeriodsBackward);

        $this->assertSame('2020-01-04', $timePeriodsBackward->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward->all()[0]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-03', $timePeriodsBackward->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward->all()[1]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriodsBackward->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward->all()[2]->end()->format('Y-m-d'));
    }

    public function test_iterating_by_month_interval_closed_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2021-01-01 00:00:00.0000')
        );

        $timePeriods = $period->iterate(RelativeTimeUnit::month(), Interval::closed());
        $timePeriodsBackward = $period->iterateBackward(RelativeTimeUnit::month(), Interval::closed());

        $this->assertCount(12, $timePeriods);
        $this->assertCount(12, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods->all()[0]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods->all()[0]->distance()->inDays());
        $this->assertSame('2020-02-01', $timePeriods->all()[1]->start()->format('Y-m-d'));
        $this->assertSame(29, $timePeriods->all()[1]->distance()->inDays());
        $this->assertSame('2020-03-01', $timePeriods->all()[2]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods->all()[2]->distance()->inDays());
        $this->assertSame('2020-04-01', $timePeriods->all()[3]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods->all()[3]->distance()->inDays());
        $this->assertSame('2020-05-01', $timePeriods->all()[4]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods->all()[4]->distance()->inDays());
        $this->assertSame('2020-06-01', $timePeriods->all()[5]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods->all()[5]->distance()->inDays());
        $this->assertSame('2020-07-01', $timePeriods->all()[6]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods->all()[6]->distance()->inDays());
        $this->assertSame('2020-08-01', $timePeriods->all()[7]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods->all()[7]->distance()->inDays());
        $this->assertSame('2020-09-01', $timePeriods->all()[8]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods->all()[8]->distance()->inDays());
        $this->assertSame('2020-10-01', $timePeriods->all()[9]->start()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods->all()[9]->distance()->inDays());
        $this->assertSame('2020-11-01', $timePeriods->all()[10]->start()->format('Y-m-d'));
        $this->assertSame(30, $timePeriods->all()[10]->distance()->inDays());
        $this->assertSame('2020-12-01', $timePeriods->all()[11]->start()->format('Y-m-d'));
        $this->assertSame('2021-01-01', $timePeriods->all()[11]->end()->format('Y-m-d'));
        $this->assertSame(31, $timePeriods->all()[11]->distance()->inDays());

        $this->assertSame('2021-01-01', $timePeriodsBackward->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2020-12-01', $timePeriodsBackward->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2020-11-01', $timePeriodsBackward->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2020-10-01', $timePeriodsBackward->all()[3]->start()->format('Y-m-d'));
        $this->assertSame('2020-09-01', $timePeriodsBackward->all()[4]->start()->format('Y-m-d'));
        $this->assertSame('2020-08-01', $timePeriodsBackward->all()[5]->start()->format('Y-m-d'));
        $this->assertSame('2020-07-01', $timePeriodsBackward->all()[6]->start()->format('Y-m-d'));
        $this->assertSame('2020-06-01', $timePeriodsBackward->all()[7]->start()->format('Y-m-d'));
        $this->assertSame('2020-05-01', $timePeriodsBackward->all()[8]->start()->format('Y-m-d'));
        $this->assertSame('2020-04-01', $timePeriodsBackward->all()[9]->start()->format('Y-m-d'));
        $this->assertSame('2020-03-01', $timePeriodsBackward->all()[10]->start()->format('Y-m-d'));
        $this->assertSame('2020-02-01', $timePeriodsBackward->all()[11]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward->all()[11]->end()->format('Y-m-d'));
    }

    public function test_iterating_by_year_interval_closed_both_ways() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2025-01-01 00:00:00.0000')
        );

        $timePeriods = $period->iterate(RelativeTimeUnit::year(), Interval::closed());
        $timePeriodsBackward = $period->iterateBackward(RelativeTimeUnit::year(), Interval::closed());

        $this->assertCount(5, $timePeriods);
        $this->assertCount(5, $timePeriodsBackward);

        $this->assertSame('2020-01-01', $timePeriods->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2021-01-01', $timePeriods->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2022-01-01', $timePeriods->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2023-01-01', $timePeriods->all()[3]->start()->format('Y-m-d'));
        $this->assertSame('2024-01-01', $timePeriods->all()[4]->start()->format('Y-m-d'));
        $this->assertSame('2025-01-01', $timePeriods->all()[4]->end()->format('Y-m-d'));

        $this->assertSame('2025-01-01', $timePeriodsBackward->all()[0]->start()->format('Y-m-d'));
        $this->assertSame('2024-01-01', $timePeriodsBackward->all()[1]->start()->format('Y-m-d'));
        $this->assertSame('2023-01-01', $timePeriodsBackward->all()[2]->start()->format('Y-m-d'));
        $this->assertSame('2022-01-01', $timePeriodsBackward->all()[3]->start()->format('Y-m-d'));
        $this->assertSame('2021-01-01', $timePeriodsBackward->all()[4]->start()->format('Y-m-d'));
        $this->assertSame('2020-01-01', $timePeriodsBackward->all()[4]->end()->format('Y-m-d'));
    }

    public function test_iterating_through_day_backward_by_2_days() : void
    {
        $period = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $timePeriods = $period->iterateBackward(TimeUnit::days(2), Interval::closed());

        $this->assertSame('2020-01-01', $timePeriods->all()[0]->end()->format('Y-m-d'));
        $this->assertSame('2020-01-02', $timePeriods->all()[0]->start()->format('Y-m-d'));

        $this->assertCount(1, $timePeriods);
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
            (new TimePeriod(DateTime::fromString('2020-01-01 00:00:00'), DateTime::fromString('2020-01-02 00:00:00')))
                ->contains(new TimePeriod(DateTime::fromString('2020-01-01 00:00:00'), DateTime::fromString('2020-01-02 00:00:00')))
        );
    }

    public function test_one_period_contains_shorted_period() : void
    {
        $this->assertTrue(
            (new TimePeriod(DateTime::fromString('2020-01-01 00:00:00'), DateTime::fromString('2020-01-05 00:00:00')))
                ->contains(new TimePeriod(DateTime::fromString('2020-01-02 00:00:00'), DateTime::fromString('2020-01-03 00:00:00')))
        );
    }

    public function test_one_period_not_contains_other_overlapping_period() : void
    {
        $this->assertFalse(
            (new TimePeriod(DateTime::fromString('2020-01-05 00:00:00'), DateTime::fromString('2020-01-10 00:00:00')))
                ->contains(new TimePeriod(DateTime::fromString('2020-01-02 00:00:00'), DateTime::fromString('2020-01-07 00:00:00')))
        );
    }

    public function test_merge_not_overlapping_time_periods() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Can't merge not overlapping time periods");

        (new TimePeriod(DateTime::fromString('2020-01-05 00:00:00'), DateTime::fromString('2020-01-10 00:00:00')))
            ->merge(new TimePeriod(DateTime::fromString('2020-01-20 00:00:00'), DateTime::fromString('2020-01-25 00:00:00')));
    }

    public function test_merge_left_overlapping_time_periods() : void
    {
        $newPeriod = (new TimePeriod(DateTime::fromString('2020-01-05 00:00:00'), DateTime::fromString('2020-01-10 00:00:00')))
            ->merge(new TimePeriod(DateTime::fromString('2020-01-08 00:00:00'), DateTime::fromString('2020-01-25 00:00:00')));

        $this->assertSame(
            '2020-01-05',
            $newPeriod->start()->format('Y-m-d')
        );

        $this->assertSame(
            '2020-01-25',
            $newPeriod->end()->format('Y-m-d')
        );
    }

    public function test_merge_abuts_time_periods() : void
    {
        $newPeriod = (new TimePeriod(DateTime::fromString('2020-01-01 00:00:00'), DateTime::fromString('2020-01-02 00:00:00')))
            ->merge(new TimePeriod(DateTime::fromString('2020-01-02 00:00:00'), DateTime::fromString('2020-01-05 00:00:00')));

        $this->assertSame(
            '2020-01-01',
            $newPeriod->start()->format('Y-m-d')
        );

        $this->assertSame(
            '2020-01-05',
            $newPeriod->end()->format('Y-m-d')
        );
    }

    public function test_merge_right_overlapping_time_periods() : void
    {
        $newPeriod = (new TimePeriod(DateTime::fromString('2020-01-10 00:00:00'), DateTime::fromString('2020-02-10 00:00:00')))
            ->merge(new TimePeriod(DateTime::fromString('2020-01-08 00:00:00'), DateTime::fromString('2020-01-25 00:00:00')));

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

        $this->assertObjectEquals(
            $timePeriod,
            \unserialize(\serialize($timePeriod)),
            'isEqual'
        );
    }

    public function test_is_equal() : void
    {
        $timePeriod1 = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00'),
            DateTime::fromString('2020-01-02 00:00:00')
        );

        $timePeriod2 = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00'),
            DateTime::fromString('2020-01-03 00:00:00')
        );

        $this->assertFalse($timePeriod1->isEqualTo($timePeriod2));
    }
}
