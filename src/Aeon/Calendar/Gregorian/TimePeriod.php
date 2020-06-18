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

    /**
     * Calculate distance between 2 points in time without leap seconds
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
