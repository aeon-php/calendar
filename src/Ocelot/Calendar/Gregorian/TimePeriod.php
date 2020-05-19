<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 * @psalm-external-mutation-free
 */
final class TimePeriod
{
    private DateTime $start;

    private DateTime $end;

    public function __construct(DateTime $start, DateTime $end)
    {
        Assert::true($start->isBeforeOrEqual($end));
        $this->start = $start;
        $this->end = $end;
    }

    public function distanceStartToEnd() : TimeUnit
    {
        return TimeUnit::seconds(
            $this->end->secondsSinceUnixEpoch() - $this->start->secondsSinceUnixEpoch()
        );
    }

    public function distanceEndToStart() : TimeUnit
    {
        return TimeUnit::seconds(
            $this->start->secondsSinceUnixEpoch() - $this->end->secondsSinceUnixEpoch()
        );
    }
}