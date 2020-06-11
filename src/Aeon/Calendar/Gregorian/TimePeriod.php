<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class TimePeriod
{
    private DateTime $start;

    private DateTime $end;

    public function __construct(DateTime $start, DateTime $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function start() : DateTime
    {
        return $this->start;
    }

    public function end() : DateTime
    {
        return $this->end;
    }

    public function distance() : TimeUnit
    {
        return TimeUnit::precise(
            (float) \sprintf("%d.%s", $this->end->secondsSinceUnixEpoch(), \str_pad((string) $this->end->time()->microsecond(), 6, "0", STR_PAD_LEFT))
            -
            (float) \sprintf("%d.%s", $this->start->secondsSinceUnixEpoch(), \str_pad((string) $this->start->time()->microsecond(), 6, "0", STR_PAD_LEFT))
        );
    }

    public function distanceBackward() : TimeUnit
    {
        return TimeUnit::precise(
            (float) \sprintf("%d.%s", $this->start->secondsSinceUnixEpoch(), \str_pad((string) $this->start->time()->microsecond(), 6, "0", STR_PAD_LEFT))
            -
            (float) \sprintf("%d.%s", $this->end->secondsSinceUnixEpoch(), \str_pad((string) $this->end->time()->microsecond(), 6, "0", STR_PAD_LEFT))
        );
    }

    public function iterate(TimeUnit $timeUnit) : TimePeriods
    {
        return new TimePeriods(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit) : TimePeriod {
                    return new TimePeriod(
                        DateTime::fromDateTime($dateTimeImmutable),
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

    public function iterateBackward(TimeUnit $timeUnit) : TimePeriods
    {
        return new TimePeriods(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit) : TimePeriod {
                    return new TimePeriod(
                        DateTime::fromDateTime($dateTimeImmutable)->add($timeUnit),
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
