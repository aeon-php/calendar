<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class TimeInterval
{
    private DateTime $startDateTime;

    private TimeUnit $interval;

    private DateTime $endDateTime;

    public function __construct(DateTime $startDateTime, TimeUnit $interval, DateTime $endDateTime)
    {
        $this->startDateTime = $startDateTime;
        $this->interval = $interval;
        $this->endDateTime = $endDateTime;
    }

    public function startDateTime() : DateTime
    {
        return $this->startDateTime;
    }

    public function interval()  : TimeUnit
    {
        return $this->interval;
    }

    public function endDateTime(): DateTime
    {
        return $this->endDateTime;
    }
}