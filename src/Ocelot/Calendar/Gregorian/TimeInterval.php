<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class TimeInterval
{
    private DateTime $pointInTime;

    private TimeUnit $interval;

    public function __construct(DateTime $pointInTime, TimeUnit $interval)
    {
        $this->pointInTime = $pointInTime;
        $this->interval = $interval;
    }

    public function dateTime() : DateTime
    {
        return $this->pointInTime;
    }

    public function interval()  : TimeUnit
    {
        return $this->interval;
    }
}