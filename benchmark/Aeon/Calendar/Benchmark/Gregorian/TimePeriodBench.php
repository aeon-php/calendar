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
    private TimePeriod $firstPeriod;

    private TimePeriod $secondPeriod;

    public function __construct()
    {
        $this->firstPeriod = new TimePeriod(DateTime::fromString('2020-01-01 00:00:00'), DateTime::fromString('2020-01-06 00:00:00'));
        $this->secondPeriod =  new TimePeriod(DateTime::fromString('2020-01-04 00:00:00'), DateTime::fromString('2020-01-08 00:00:00'));
    }

    public function bench_distance() : void
    {
        $this->firstPeriod->distance();
    }

    public function bench_overlaps() : void
    {
        $this->firstPeriod->overlaps($this->secondPeriod);
    }
}
