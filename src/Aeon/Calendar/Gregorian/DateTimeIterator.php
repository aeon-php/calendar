<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Unit;

/**
 * @implements \Iterator<DateTime>
 */
final class DateTimeIterator implements \Iterator
{
    private DateTime $currentDate;

    private DateTime $start;

    private DateTime $end;

    private Unit $timeUnit;

    private int $key;

    private bool $forward;

    private bool $empty;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(DateTime $start, DateTime $end, Unit $timeUnit)
    {
        $this->start = $start;
        $this->end = $end;
        $this->timeUnit = $timeUnit;
        $this->currentDate = $start;
        $this->key = 0;
        $this->forward = $start->isBeforeOrEqualTo($end);
        $this->empty = $start->isEqualTo($end);

        if ($this->forward && $timeUnit->isNegative()) {
            throw new InvalidArgumentException("Forward DateTimeIterator {$start->format('Y-m-d H:i:sP')}...{$end->format('Y-m-d H:i:sP')} requires positive TimeUnit");
        }

        if (!$this->forward && !$timeUnit->isNegative()) {
            throw new InvalidArgumentException("Backward DateTimeIterator {$start->format('Y-m-d H:i:sP')}...{$end->format('Y-m-d H:i:sP')} requires negative TimeUnit");
        }
    }

    public function isForward() : bool
    {
        return $this->forward;
    }

    public function unit() : Unit
    {
        return $this->timeUnit;
    }

    public function start() : DateTime
    {
        return $this->start;
    }

    public function end() : DateTime
    {
        return $this->end;
    }

    public function current() : DateTime
    {
        return $this->currentDate;
    }

    public function next() : void
    {
        $this->currentDate = $this->currentDate->add($this->timeUnit);
        $this->key++;
    }

    public function hasNext() : bool
    {
        if ($this->forward) {
            return !$this->current()->add($this->timeUnit)->isAfter($this->end);
        }

        return !$this->current()->add($this->timeUnit)->isBefore($this->end);
    }

    public function key() : int
    {
        return $this->key;
    }

    public function isFirst() : bool
    {
        return $this->key() === 0;
    }

    public function valid() : bool
    {
        if ($this->empty) {
            return false;
        }

        if ($this->forward) {
            return $this->currentDate->isBeforeOrEqualTo($this->end);
        }

        return $this->currentDate->isAfterOrEqualTo($this->end);
    }

    public function rewind() : void
    {
        $this->currentDate = $this->start;
        $this->key = 0;
    }
}
