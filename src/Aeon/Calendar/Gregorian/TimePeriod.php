<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\TimeUnit;
use Aeon\Calendar\Unit;

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

    /**
     * @return array{start: DateTime, end: DateTime}
     */
    public function __serialize() : array
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
        ];
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
            ->toPositive();

        return $this->start->isAfter($this->end) ? $result->invert() : $result;
    }

    public function leapSeconds() : LeapSeconds
    {
        return LeapSeconds::load()->findAllBetween($this);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function iterate(Unit $timeUnit, Interval $interval) : TimePeriods
    {
        return TimePeriods::fromIterator(new TimePeriodsIterator($this->start, $this->end, $timeUnit, $interval));
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function iterateBackward(Unit $timeUnit, Interval $interval) : TimePeriods
    {
        return TimePeriods::fromIterator(new TimePeriodsIterator($this->end, $this->start, $timeUnit->toNegative(), $interval));
    }

    public function overlaps(self $timePeriod) : bool
    {
        if ($this->isBackward()) {
            $thisPeriodForward = $this->revert();
        } else {
            $thisPeriodForward = $this;
        }

        if ($timePeriod->isBackward()) {
            $otherPeriodForward = $timePeriod->revert();
        } else {
            $otherPeriodForward = $timePeriod;
        }

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

    public function contains(self $timePeriod) : bool
    {
        return $this->start->isBeforeOrEqualTo($timePeriod->start()) && $this->end->isAfterOrEqualTo($timePeriod->end());
    }

    public function revert() : self
    {
        return new self($this->end(), $this->start());
    }

    public function merge(self $timePeriod) : self
    {
        if (!$this->overlaps($timePeriod) && !$this->abuts($timePeriod)) {
            throw new InvalidArgumentException("Can't merge not overlapping time periods.");
        }

        return new self(
            $this->start->isBeforeOrEqualTo($timePeriod->start)
                ? $this->start()
                : $timePeriod->start,
            $this->end->isAfterOrEqualTo($timePeriod->end)
                ? $this->end()
                : $timePeriod->end()
        );
    }

    public function abuts(self $timePeriod) : bool
    {
        $thisPeriodForward = $this->isBackward()
            ? $this->revert()
            : $this;

        $otherPeriodForward = $timePeriod->isBackward()
            ? $timePeriod->revert()
            : $timePeriod;

        if ($thisPeriodForward->end()->isEqualTo($otherPeriodForward->start())) {
            return true;
        }

        if ($thisPeriodForward->start()->isEqualTo($otherPeriodForward->end())) {
            return true;
        }

        return false;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $period) : bool
    {
        return $this->isEqualTo($period);
    }

    public function isEqualTo(self $period) : bool
    {
        return $this->start->isEqualTo($period->start()) && $this->end->isEqualTo($period->end());
    }
}
