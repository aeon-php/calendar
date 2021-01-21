<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\Gregorian\TimePeriods;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimePeriodsTest extends TestCase
{
    public function test_offset_exists() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->until(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute(), Interval::closed());

        $this->assertFalse(isset($timePeriods[5000]));
    }

    public function test_offset_set() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->until(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute(), Interval::closed());

        $this->expectExceptionMessage('Aeon\Calendar\Gregorian\TimePeriods is immutable.');

        $timePeriods[0] = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.000000'),
            DateTime::fromString('2020-01-01 01:00:00.000000')
        );
    }

    public function test_offset_unset() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->until(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute(), Interval::closed());

        $this->expectExceptionMessage('Aeon\Calendar\Gregorian\TimePeriods is immutable.');

        unset($timePeriods[0]);
    }

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

        $this->assertSame($timePeriods->all(), (array) $timePeriods->getIterator());
    }

    public function test_gap_for_empty_periods() : void
    {
        $this->assertCount(0, (new TimePeriods())->gaps());
    }

    public function test_gap_for_periods_with_one_period() : void
    {
        $this->assertCount(
            0,
            (new TimePeriods(
                new TimePeriod(DateTime::fromString('2020-01-01 01:00:00.000000'), DateTime::fromString('2020-01-02 01:00:00.000000'))
            ))->gaps()
        );
    }

    public function test_gap_for_periods_with_equal_time_periods() : void
    {
        $this->assertCount(
            0,
            (new TimePeriods(
                new TimePeriod(DateTime::fromString('2020-01-01 01:00:00.000000'), DateTime::fromString('2020-01-02 01:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 01:00:00.000000'), DateTime::fromString('2020-01-02 01:00:00.000000'))
            ))->gaps()
        );
    }

    public function test_gap_periods() : void
    {
        $this->assertEquals(
            (new TimePeriods(
                new TimePeriod(DateTime::fromString('2020-01-02 00:00:00.000000'), DateTime::fromString('2020-01-03 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-07 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            )),
            (new TimePeriods(
                new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
                new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000')),
            ))->gaps()
        );
    }

    public function test_map_periods() : void
    {
        $timePeriods = new TimePeriods(
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
        $timePeriods = new TimePeriods(
            new TimePeriod(DateTime::fromString('2020-01-10 00:00:00.000000'), DateTime::fromString('2020-01-08 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-01 00:00:00.000000'), DateTime::fromString('2020-01-02 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-05 00:00:00.000000'), DateTime::fromString('2020-01-07 00:00:00.000000')),
            new TimePeriod(DateTime::fromString('2020-01-03 00:00:00.000000'), DateTime::fromString('2020-01-06 00:00:00.000000'))
        );

        $this->assertCount(
            1,
            $distances = $timePeriods->filter(fn (TimePeriod $timePeriod) => $timePeriod->start()->isEqual(DateTime::fromString('2020-01-03 00:00:00.000000')))
        );
        $this->assertInstanceOf(TimePeriod::class, $distances[0]);
    }
}
