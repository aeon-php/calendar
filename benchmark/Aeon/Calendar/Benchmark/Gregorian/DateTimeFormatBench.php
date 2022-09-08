<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;

/**
 * @revs(50)
 * @iterations(10)
 * @outputTimeUnit("milliseconds")
 * @BeforeMethods({"init"})
 */
final class DateTimeFormatBench
{
    private DateTime $aeonDateTime;

    private \DateTimeImmutable $dateTime;

    public function init() : void
    {
        $this->aeonDateTime = DateTime::fromString('2020-01-01 00:00:00');
        $this->dateTime = new \DateTimeImmutable('2020-01-01 00:00:00');
    }

    public function bench_aeon_format() : void
    {
        $this->aeonDateTime->format('Y-m-d H:i:s.u P');
    }

    public function bench_php_format() : void
    {
        $this->dateTime->format('Y-m-d H:i:s.u P');
    }
}
