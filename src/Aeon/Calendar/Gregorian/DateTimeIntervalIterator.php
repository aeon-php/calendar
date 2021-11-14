<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Unit;

final class DateTimeIntervalIterator extends \FilterIterator
{
    private Interval $interval;

    public function __construct(DateTime $start, DateTime $end, Unit $timeUnit, Interval $interval)
    {
        $this->interval = $interval;
        parent::__construct(new DateTimeIterator($start, $end, $timeUnit));
    }

    public function start() : DateTime
    {
        return $this->getInnerIterator()->start();
    }

    public function end() : DateTime
    {
        return $this->getInnerIterator()->end();
    }

    public function unit() : Unit
    {
        return $this->getInnerIterator()->unit();
    }

    public function isForward() : bool
    {
        return $this->getInnerIterator()->isForward();
    }

    public function interval() : Interval
    {
        return $this->interval;
    }

    public function hasNext() : bool
    {
        $dateTimeIterator = clone $this->getInnerIterator();

        $dateTimeIterator->next();

        if ($dateTimeIterator->isForward()) {
            if ($this->interval->isRightOpen() && !$dateTimeIterator->hasNext()) {
                return false;
            }

            if ($dateTimeIterator->current()->isAfter($dateTimeIterator->end())) {
                return false;
            }
        } else {
            if ($this->interval->isLeftOpen() && !$dateTimeIterator->hasNext()) {
                return false;
            }

            if ($dateTimeIterator->current()->isBefore($dateTimeIterator->end())) {
                return false;
            }
        }

        return true;
    }

    public function accept() : bool
    {
        $dateTimeIterator = $this->getInnerIterator();

        if ($dateTimeIterator->isForward()) {
            if (($this->interval->isRightOpen() || $this->interval->isOpen()) && !$dateTimeIterator->hasNext()) {
                return false;
            }

            if (($this->interval->isLeftOpen() || $this->interval->isOpen()) && $dateTimeIterator->isFirst()) {
                return false;
            }
        } else {
            if (($this->interval->isRightOpen() || $this->interval->isOpen()) && $dateTimeIterator->isFirst()) {
                return false;
            }

            if (($this->interval->isLeftOpen() || $this->interval->isOpen()) && !$dateTimeIterator->hasNext()) {
                return false;
            }
        }

        return true;
    }

    public function key() : int
    {
        $dateTimeIterator = $this->getInnerIterator();

        if ($dateTimeIterator->isForward()) {
            if ($this->interval->isLeftOpen() || $this->interval->isOpen()) {
                return $dateTimeIterator->key() - 1;
            }
        } else {
            if ($this->interval->isRightOpen() || $this->interval->isOpen()) {
                return $dateTimeIterator->key() - 1;
            }
        }

        return $dateTimeIterator->key();
    }

    /**
     * @psalm-suppress MixedReturnStatement
     */
    public function current() : ?DateTime
    {
        /**
         * @phpstan-ignore-next-line
         */
        return parent::current();
    }

    /**
     * @psalm-suppress InvalidReturnStatement
     * @psalm-suppress InvalidReturnType
     */
    public function getInnerIterator() : DateTimeIterator
    {
        /** @phpstan-ignore-next-line */
        return parent::getInnerIterator();
    }
}
