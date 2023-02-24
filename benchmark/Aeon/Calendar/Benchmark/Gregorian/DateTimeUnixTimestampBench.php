<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;

/**
 * @revs(50)
 *
 * @iterations(10)
 *
 * @outputTimeUnit("milliseconds")
 */
final class DateTimeUnixTimestampBench
{
    private DateTime $aeonDateTime;

    private \DateTimeImmutable $dateTime;

    public function __construct()
    {
        $this->aeonDateTime = DateTime::fromString('2020-01-01 00:00:00');
        $this->dateTime = new \DateTimeImmutable('2020-01-01 00:00:00');
    }

    public function bench_aeon_unix_timestamp() : void
    {
        $this->aeonDateTime->timestampUNIX();
    }

    public function bench_php_unix_timestamp() : void
    {
        $this->dateTime->getTimestamp();
    }
}
