<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\TimeUnit;

/**
 * @revs(50)
 * @iterations(10)
 * @outputTimeUnit("milliseconds")
 */
final class TimeUnitInitBench
{
    public function bench_time_unit_positive() : void
    {
        TimeUnit::positive(100, 50000);
    }

    public function bench_time_unit_negative() : void
    {
        TimeUnit::positive(100, 50000);
    }
}
