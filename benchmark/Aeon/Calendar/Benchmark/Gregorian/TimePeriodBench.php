<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\TimePeriod;

/**
 * @iterations(5)
 * @revs(5)
 * @outputTimeUnit("milliseconds")
 */
final class TimePeriodBench
{
    public function bench_distance() : void
    {
        (new TimePeriod(DateTime::fromString('2020-01-01 00:00:00'), DateTime::fromString('2020-01-06 00:00:00')))
            ->distance();
    }

    public function bench_overlaps() : void
    {
        (new TimePeriod(DateTime::fromString('2020-01-01 00:00:00'), DateTime::fromString('2020-01-06 00:00:00')))
            ->overlaps(
                new TimePeriod(DateTime::fromString('2020-01-04 00:00:00'), DateTime::fromString('2020-01-08 00:00:00'))
            );
    }
}
