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
        $result = TimeUnit::seconds(0);

        if ($this->start->timestampUNIX()->isPositive() && $this->end->timestampUNIX()->isPositive()) {
            $result = $this->end->timestampUNIX()
                ->sub($this->start->timestampUNIX())
                ->absolute();
        }

        if ($this->start->timestampUNIX()->isNegative() && $this->end->timestampUNIX()->isNegative()) {
            $result = $this->end->timestampUNIX()
                ->add($this->start->timestampUNIX()->invert())
                ->absolute();
        }

        if ($this->start->timestampUNIX()->isNegative() && $this->end->timestampUNIX()->isPositive()) {
            $result = $this->end->timestampUNIX()
                ->add($this->start->timestampUNIX()->invert())
                ->absolute();
        }

        if ($this->start->timestampUNIX()->isPositive() && $this->end->timestampUNIX()->isNegative()) {
            $result = $this->end->timestampUNIX()->invert()
                ->add($this->start->timestampUNIX())
                ->absolute();
        }

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

        if ($thisPeriodForward->start()->isBefore($otherPeriodForward->start()) &&
            $thisPeriodForward->start()->isBefore($otherPeriodForward->end()) &&
            $thisPeriodForward->end()->isBefore($otherPeriodForward->start()) &&
            $thisPeriodForward->end()->isBefore($otherPeriodForward->end())
        ) {
            return false;
        }

        if ($thisPeriodForward->start()->isBefore($otherPeriodForward->start()) &&
            $thisPeriodForward->start()->isBefore($otherPeriodForward->end()) &&
            $thisPeriodForward->end()->isAfter($otherPeriodForward->start()) &&
            $thisPeriodForward->end()->isBefore($otherPeriodForward->end())
        ) {
            return true;
        }

        if ($thisPeriodForward->start()->isAfter($otherPeriodForward->start()) &&
            $thisPeriodForward->start()->isBefore($otherPeriodForward->end()) &&
            $thisPeriodForward->end()->isAfter($otherPeriodForward->start()) &&
            $thisPeriodForward->end()->isBefore($otherPeriodForward->end())
        ) {
            return true;
        }

        if ($thisPeriodForward->start()->isAfter($otherPeriodForward->start()) &&
            $thisPeriodForward->start()->isBefore($otherPeriodForward->end()) &&
            $thisPeriodForward->end()->isAfter($otherPeriodForward->start()) &&
            $thisPeriodForward->end()->isAfter($otherPeriodForward->end())
        ) {
            return true;
        }

        if ($thisPeriodForward->start()->isAfter($otherPeriodForward->start()) &&
            $thisPeriodForward->start()->isAfter($otherPeriodForward->end()) &&
            $thisPeriodForward->end()->isAfter($otherPeriodForward->start()) &&
            $thisPeriodForward->end()->isAfter($otherPeriodForward->end())
        ) {
            return false;
        }

        if ($thisPeriodForward->abuts($otherPeriodForward)) {
            return false;
        }

        if ($otherPeriodForward->abuts($thisPeriodForward)) {
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
