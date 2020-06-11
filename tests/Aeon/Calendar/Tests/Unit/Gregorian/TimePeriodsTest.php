<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimePeriodsTest extends TestCase
{
    public function test_offset_exists() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->assertFalse(isset($timePeriods[5000]));
    }

    public function test_offset_set() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->expectExceptionMessage('Aeon\Calendar\Gregorian\TimePeriods is immutable.');

        $timePeriods[0] = new TimePeriod(
            DateTime::fromString('2020-01-01 00:00:00.000000'),
            DateTime::fromString('2020-01-01 01:00:00.000000')
        );
    }

    public function test_offset_unset() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->expectExceptionMessage('Aeon\Calendar\Gregorian\TimePeriods is immutable.');

        unset($timePeriods[0]);
    }

    public function test_each() : void
    {
        $counter = 0;
        DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute())
            ->each(function (TimePeriod $timePeriod) use (&$counter) : void {
                /** @psalm-suppress MixedOperand */
                $counter += 1;
            });

        $this->assertSame(60, $counter);
    }

    public function test_get_iterator() : void
    {
        $timePeriods = DateTime::fromString('2020-01-01 00:00:00.000000')
            ->to(DateTime::fromString('2020-01-01 01:00:00.000000'))
            ->iterate(TimeUnit::minute());

        $this->assertSame($timePeriods->all(), (array) $timePeriods->getIterator());
    }
}
