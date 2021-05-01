<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\Gregorian\TimePeriods;
use Aeon\Calendar\Gregorian\TimePeriodsSort;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimePeriodsTest extends TestCase
{
    public function test_each() : void
    {
        $counter = 0;
        DateTime::fromString('2020-01-01 00:00:00.000000')
            ->until(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute(), Interval::rightOpen())
            ->each(function (TimePeriod $timePeriod) use (&$counter) : void {
                /** @psalm-suppress MixedOperand */
                $counter += 1;
            });

        $this->assertSame(59, $counter);
    }

    public function test_get_iterator() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->until(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute(), Interval::closed());

        $this->assertEquals($timePeriods->all(), \iterator_to_array($timePeriods->getIterator()));
    }

    public function test_gap_for_empty_periods() : void
    {
        $this->assertCount(0, (TimePeriods::fromArray())->gaps());
    }

    public function test_gap_for_periods_with_one_period() : void
    {
        $this->assertCount(
            0,
            (TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-01 01:00:00.000000'), DateTime::fromString('2020-01-02 01:00:00.000000'))
            ))->gaps()
        );
    }

    public function test_gap_for_periods_with_equal_time_periods() : void
    {
        $this->assertCount(
            0,
            (TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-01 01:00:00.000000'), DateTime::fromString('2020-01-02 01:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 01:00:00.000000'), DateTime::fromString('2020-01-02 01:00:00.000000'))
            ))->gaps()
        );
    }

    public function test_gap_periods() : void
    {
        $this->assertEquals(
            (TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.000000'), DateTime::fromString('2020-01-03 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-07 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            )),
            (TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
            ))->gaps()
        );
    }

    public function test_no_gaps_in_overlapping_periods() : void
    {
        $this->assertEquals(
            (TimePeriods::fromArray()),
            (TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2021-01-15T00:00:00+00:00'), DateTime::fromString('2021-01-29T00:00:00+00:00')),
                new TimePeriod(DateTime::fromString('2021-01-06T14:32:01+00:00'), DateTime::fromString('2021-01-20T15:24:53+00:00')),
                new TimePeriod(DateTime::fromString('2021-01-10T13:03:08+00:00'), DateTime::fromString('2021-01-13T14:24:54+00:00')),
                new TimePeriod(DateTime::fromString('2020-12-11T13:03:08+00:00'), DateTime::fromString('2021-01-10T13:03:08+00:00')),
            ))->gaps()
        );
    }

    public function test_no_gaps_in_abuts_periods() : void
    {
        $this->assertEquals(
            (TimePeriods::fromArray()),
            (TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2019-09-09T12:53:30+00:00'), DateTime::fromString('2019-10-09T12:53:30+00:00')),
                new TimePeriod(DateTime::fromString('2019-08-10T12:53:30+00:00'), DateTime::fromString('2019-09-09T12:53:30+00:00')),
                new TimePeriod(DateTime::fromString('2019-07-11T12:53:30+00:00'), DateTime::fromString('2019-08-10T12:53:30+00:00')),
            ))->gaps()
        );
    }

    public function test_map_periods() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000'))
        );

        $this->assertCount(
            4,
            $distances = $timePeriods->map(fn (TimePeriod $timePeriod) => $timePeriod->distance())
        );
        $this->assertInstanceOf(TimeUnit::class, $distances[0]);
    }

    public function test_filter_periods() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000'))
        );

        $this->assertCount(
            1,
            $distances = $timePeriods->filter(fn (TimePeriod $timePeriod) => $timePeriod->start()->isEqual(DateTime::fromString('2020-01-03 00:00:00.000000')))
        );
        $this->assertInstanceOf(TimePeriod::class, \array_values($distances->all())[0]);
    }

    public function test_sort_by_start_date_asc() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );

        $this->assertEquals(
            TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            ),
            $timePeriods->sort()
        );
    }

    public function test_sort_by_start_date_desc() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );

        $this->assertEquals(
            TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            ),
            $timePeriods->sortBy(TimePeriodsSort::desc())
        );
    }

    public function test_sort_by_end_date_asc() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );

        $this->assertEquals(
            TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            ),
            $timePeriods->sortBy(TimePeriodsSort::endDate())
        );
    }

    public function test_sort_by_end_date_desc() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );

        $this->assertEquals(
            TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            ),
            $timePeriods->sortBy(TimePeriodsSort::endDate(false))
        );
    }

    public function test_first() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );

        $this->assertEquals(
            $timePeriods->first(),
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
        );
    }

    public function test_first_empty() : void
    {
        $this->assertNull(
            (TimePeriods::fromArray())->first(),
        );
    }

    public function test_last() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );

        $this->assertEquals(
            $timePeriods->last(),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );
    }

    public function test_last_empty() : void
    {
        $this->assertNull(
            (TimePeriods::fromArray())->first(),
        );
    }

    public function test_add() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
        );
        $timePeriods = $timePeriods->add(
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
        );

        $this->assertEquals(
            $timePeriods,
            TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
            )
        );
    }

    public function test_merge() : void
    {
        $timePeriods = TimePeriods::fromArray(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
        );
        $timePeriods = $timePeriods->merge(
            TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
            )
        );

        $this->assertEquals(
            $timePeriods,
            TimePeriods::fromArray(
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
            )
        );
    }
}
