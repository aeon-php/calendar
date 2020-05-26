<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit\Gregorian;

use Ocelot\Calendar\Gregorian\DateTime;
use Ocelot\Calendar\Gregorian\TimeInterval;
use Ocelot\Calendar\Gregorian\TimeIntervals;
use Ocelot\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimeIntervalsTest extends TestCase
{
    public function test_offset_exists() : void
    {
        $timeIntervals = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->assertFalse(isset($timeIntervals[5000]));
    }

    public function test_offset_set() : void
    {
        $timeIntervals = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->expectExceptionMessage('Ocelot\Calendar\Gregorian\TimeIntervals is immutable.');

        $timeIntervals[0] = new TimeInterval(
            DateTime::fromString('2020-01-01 00:00:00.000000'),
            TimeUnit::hour(),
            DateTime::fromString('2020-01-01 01:00:00.000000')
        );
    }

    public function test_offset_unset() : void
    {
        $timeIntervals = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->expectExceptionMessage('Ocelot\Calendar\Gregorian\TimeIntervals is immutable.');

        unset($timeIntervals[0]);
    }

    public function test_each() : void
    {
        $counter = 0;
        DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute())
            ->each(function (TimeInterval $timeInterval) use (&$counter) : void {
                /** @psalm-suppress MixedOperand */
                $counter += 1;
            });

        $this->assertSame(60, $counter);
    }

    public function test_get_iterator() : void
    {
        $intervals = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->assertSame($intervals->all(), (array) $intervals->getIterator());
    }
}