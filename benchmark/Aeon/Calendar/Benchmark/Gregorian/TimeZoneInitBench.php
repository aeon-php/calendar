<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\TimeZone;

/**
 * @revs(50)
 *
 * @iterations(10)
 *
 * @outputTimeUnit("milliseconds")
 */
final class TimeZoneInitBench
{
    public function bench_time_zone_init_by_static_name() : void
    {
        TimeZone::europeWarsaw();
    }

    public function bench_time_zone_init_by_abbreviation() : void
    {
        TimeZone::abbreviation('CEST');
    }

    public function bench_time_zone_init_by_id() : void
    {
        TimeZone::id('Europe/Warsaw');
    }

    public function bench_time_zone_init_by_offset() : void
    {
        TimeZone::offset('+01:00');
    }

    public function bench_time_zone_init_by_string() : void
    {
        TimeZone::fromString('Europe/Warsaw');
    }

    public function bench_php_datetime_zone_constructor() : void
    {
        new \DateTimeZone('Europe/Warsaw');
    }
}
