<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Unit;

final class TimePeriodsIterator extends \FilterIterator
{
    private Interval $interval;

    public function __construct(DateTime $start, DateTime $end, Unit $timeUnit, Interval $interval)
    {
        $this->interval = $interval;

        parent::__construct(new DateTimeIterator($start, $end, $timeUnit));
    }

    public function current() : ?TimePeriod
    {
        $dateTimeIterator = $this->getInnerIterator();

        $end = $dateTimeIterator->end();

        $currentStart = $dateTimeIterator->current();
        $currentEnd = $dateTimeIterator->current()->add($dateTimeIterator->unit());

        if ($dateTimeIterator->isForward()) {
            if ($currentEnd->isAfterOrEqualTo($end)) {
                $currentEnd = $end;
            }
        } else {
            if ($currentEnd->isBeforeOrEqualTo($end)) {
                $currentEnd = $end;
            }
        }

        return new TimePeriod($currentStart, $currentEnd);
    }

    public function accept() : bool
    {
        $dateTimeIterator = $this->getInnerIterator();
        $current = $dateTimeIterator->current();
        $end = $dateTimeIterator->end();

        if ($dateTimeIterator->isForward()) {
            if ($current->isAfterOrEqualTo($end)) {
                return false;
            }

            if ($this->interval->isRightOpen() && $current->add($dateTimeIterator->unit())->isAfterOrEqualTo($end)) {
                return false;
            }

            if ($this->interval->isLeftOpen() && $dateTimeIterator->isFirst()) {
                return false;
            }
        } else {
            if ($current->isBeforeOrEqualTo($end)) {
                return false;
            }

            if (($this->interval->isRightOpen()) && $dateTimeIterator->isFirst()) {
                return false;
            }

            if (($this->interval->isLeftOpen()) && $current->add($dateTimeIterator->unit())->isBeforeOrEqualTo($end)) {
                return false;
            }
        }

        return true;
    }

    public function key() : int
    {
        $dateTimeIterator = $this->getInnerIterator();

        if ($dateTimeIterator->isForward()) {
            if ($this->interval->isLeftOpen()) {
                return $dateTimeIterator->key() - 1;
            }
        } else {
            if ($this->interval->isRightOpen()) {
                return $dateTimeIterator->key() - 1;
            }
        }

        return $dateTimeIterator->key();
    }

    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function getInnerIterator() : DateTimeIterator
    {
        /** @phpstan-ignore-next-line  */
        return parent::getInnerIterator();
    }
}
