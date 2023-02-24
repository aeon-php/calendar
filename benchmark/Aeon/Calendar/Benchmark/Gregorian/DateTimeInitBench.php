<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Time;
use Aeon\Calendar\Gregorian\TimeZone;
use Aeon\Calendar\Gregorian\Year;

/**
 * @revs(50)
 *
 * @iterations(10)
 *
 * @outputTimeUnit("milliseconds")
 */
final class DateTimeInitBench
{
    public function bench_datetime_immutable_constructor() : void
    {
        new \DateTimeImmutable('2020-01-01 00:00:00.00000 UTC');
    }

    public function bench_datetime_constructor() : void
    {
        new \DateTime('2020-01-01 00:00:00.00000 UTC');
    }

    public function bench_aeon_datetime_from_datetime_immutable() : void
    {
        DateTime::fromDateTime(new \DateTimeImmutable('2020-01-01 00:00:00.00000 UTC'));
    }

    public function bench_aeon_datetime_create() : void
    {
        DateTime::create(2020, 01, 01, 00, 00, 00, 0, 'UTC');
    }

    public function bench_aeon_datetime_constructor() : void
    {
        new DateTime(
            new Day(new Month(new Year(2020), 01), 01),
            new Time(00, 00, 00, 0),
            TimeZone::fromString('UTC')
        );
    }

    public function bench_aeon_datetime_from_string() : void
    {
        DateTime::fromString('2020-01-01 00:00:00.00000 UTC');
    }
}
