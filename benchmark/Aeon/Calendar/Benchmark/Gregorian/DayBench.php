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
    private Day $day;

    private Day $futureDay;

    public function __construct()
    {
        $this->day = Day::fromString('2020-01-01');
        $this->futureDay = Day::fromString('2020-01-06');
    }

    public function bench_time_between() : void
    {
        $this->day->timeBetween($this->futureDay)->inDays();
    }

    public function bench_to_datetime_immutable() : void
    {
        $this->day->toDateTimeImmutable();
    }

    public function bench_is_equal() : void
    {
        $this->day->isEqual($this->futureDay);
    }

    public function bench_is_before() : void
    {
        $this->day->isBefore($this->futureDay);
    }

    public function bench_is_after() : void
    {
        $this->day->isAfter($this->futureDay);
    }

    public function bench_is_before_eq() : void
    {
        $this->day->isBeforeOrEqual($this->futureDay);
    }

    public function bench_is_after_eq() : void
    {
        $this->day->isAfterOrEqual($this->futureDay);
    }
}
