<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;

/**
 * @iterations(5)
 * @revs(5)
 * @outputTimeUnit("milliseconds")
 */
final class DateTimeBench
{
    public function bench_unix_timestamp() : void
    {
        DateTime::fromString('2020-01-01')->timestampUNIX();
    }

    public function bench_to_datetime_immutable() : void
    {
        DateTime::fromString('2020-01-01')->toDateTimeImmutable();
    }
}
