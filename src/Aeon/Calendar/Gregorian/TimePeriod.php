<?php

declare(strict_types=1);

/*
 * This file is part of the Aeon time management framework for PHP.
 *
 * (c) Norbert Orzechowicz <contact@norbert.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\TimeUnit;
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
            (float) \sprintf("%d.%s", $this->end->secondsSinceUnixEpoch(), \str_pad((string) $this->end->time()->microsecond(), 6, "0", STR_PAD_LEFT))
            -
            (float) \sprintf("%d.%s", $this->start->secondsSinceUnixEpoch(), \str_pad((string) $this->start->time()->microsecond(), 6, "0", STR_PAD_LEFT))
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
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit) {
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
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit) {
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
