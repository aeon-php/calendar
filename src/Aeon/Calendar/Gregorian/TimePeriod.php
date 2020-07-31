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

    public function isForward() : bool
    {
        return $this->distance()->isPositive();
    }

    public function isBackward() : bool
    {
        return $this->distance()->isNegative();
    }

    /**
     * Calculate distance between 2 points in time without leap seconds.
     */
    public function distance() : TimeUnit
    {
        $startUnixTimestamp = $this->start->timestampUNIX();
        $endUnixTimestamp = $this->end->timestampUNIX();

        $result = $endUnixTimestamp
            ->sub($startUnixTimestamp)
            ->absolute();

        return $this->start->isAfter($this->end) ? $result->invert() : $result;
    }

    public function leapSeconds() : LeapSeconds
    {
        return LeapSeconds::load()->findAllBetween($this);
    }

    public function iterate(TimeUnit $timeUnit) : TimePeriods
    {
        return new TimePeriods(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit) : self {
                    return new self(
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
                function (\DateTimeImmutable $dateTimeImmutable) use ($timeUnit) : self {
                    return new self(
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

    public function overlaps(self $timePeriod) : bool
    {
        $thisPeriodForward = $this->isBackward()
            ? $this->revert()
            : $this;

        $otherPeriodForward = $timePeriod->isBackward()
            ? $timePeriod->revert()
            : $timePeriod;

        $thisPeriodStart = $thisPeriodForward->start();
        $thisPeriodEnd = $thisPeriodForward->end();
        $otherPeriodStart = $otherPeriodForward->start();
        $otherPeriodEnd = $otherPeriodForward->end();

        if ($thisPeriodForward->abuts($otherPeriodForward)) {
            return false;
        }

        if ($thisPeriodStart->isBefore($otherPeriodStart) &&
            $thisPeriodEnd->isBefore($otherPeriodStart) &&
            $thisPeriodEnd->isBefore($otherPeriodEnd)
        ) {
            return false;
        }

        if ($thisPeriodEnd->isBefore($otherPeriodEnd)) {
            return true;
        }

        if ($thisPeriodStart->isAfter($otherPeriodStart) &&
            $thisPeriodStart->isBefore($otherPeriodEnd) &&
            $thisPeriodEnd->isAfter($otherPeriodStart)
        ) {
            return true;
        }

        if ($thisPeriodStart->isAfter($otherPeriodStart) &&
            $thisPeriodEnd->isAfter($otherPeriodStart) &&
            $thisPeriodEnd->isAfter($otherPeriodEnd)
        ) {
            return false;
        }

        return true;
    }

    public function revert() : self
    {
        return new self($this->end(), $this->start());
    }

    public function abuts(self $timePeriod) : bool
    {
        $thisPeriodForward = $this->isBackward()
            ? $this->revert()
            : $this;

        $otherPeriodForward = $timePeriod->isBackward()
            ? $timePeriod->revert()
            : $timePeriod;

        if ($thisPeriodForward->end()->isEqual($otherPeriodForward->start())) {
            return true;
        }

        if ($thisPeriodForward->start()->isEqual($otherPeriodForward->end())) {
            return true;
        }

        return false;
    }
}
