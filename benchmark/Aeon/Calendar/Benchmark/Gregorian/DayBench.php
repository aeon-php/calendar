<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\Day;

/**
 * @iterations(5)
 * @revs(5)
 * @outputTimeUnit("milliseconds")
 */
final class DayBench
{
    public function bench_time_between() : void
    {
        Day::fromString('2020-01-01')->timeBetween(Day::fromString('2020-01-06'))->inDays();
    }

    public function bench_to_datetime_immutable() : void
    {
        Day::fromString('2020-01-01')->toDateTimeImmutable();
    }
}
