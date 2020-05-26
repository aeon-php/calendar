<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Gregorian;

use Ocelot\Calendar\TimeUnit;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class TimePeriod
{
    private DateTime $start;

    private DateTime $end;

    public function __construct(DateTime $start, DateTime $end)
    {
        Assert::true($start->isBeforeOrEqual($end), "Start date of period must be before end date");
        $this->start = $start;
        $this->end = $end;
    }

    public function distance() : TimeUnit
    {
        return TimeUnit::precise(
            (float) \sprintf("%d.%d", $this->end->secondsSinceUnixEpoch(), $this->end->time()->microsecond())
            -
            (float) \sprintf("%d.%d", $this->start->secondsSinceUnixEpoch(), $this->start->time()->microsecond())
        );
    }

    public function distanceBackward() : TimeUnit
    {
        return TimeUnit::seconds(
            $this->start->secondsSinceUnixEpoch() - $this->end->secondsSinceUnixEpoch()
        );
    }

    public function iterate(TimeUnit $timeUnit) : TimeIntervals
    {
        return new TimeIntervals(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit)  {
                    return new TimeInterval(
                        DateTime::fromDateTime($dateTimeImmutable),
                        $timeUnit,
                        DateTime::fromDateTime($dateTimeImmutable)->add($timeUnit)
                    );
                },
                \iterator_to_array(
                    new \DatePeriod(
                        $this->start->toDateTimeImmutable(),
                        $timeUnit->toDateInterval(),
                        $this->end->toDateTimeImmutable()
                    )
                )
            )
        );
    }

    public function iterateBackward(TimeUnit $timeUnit) : TimeIntervals
    {
        return new TimeIntervals(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit)  {
                    return new TimeInterval(
                        DateTime::fromDateTime($dateTimeImmutable)->add($timeUnit),
                        $timeUnit->invert(),
                        DateTime::fromDateTime($dateTimeImmutable)
                    );
                },
                \array_reverse(
                    \iterator_to_array(
                        new \DatePeriod(
                            $this->start->toDateTimeImmutable(),
                            $timeUnit->toDateInterval(),
                            $this->end->toDateTimeImmutable()
                        )
                    )
                )
            )
        );
    }
}