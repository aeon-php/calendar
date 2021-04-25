<?php

declare(strict_types=1);

namespace Aeon\Calendar;

use Aeon\Calendar\Gregorian\DateTime;

/**
 * @implements \Iterator<DateTime>
 */
final class DateTimeIterator implements \Iterator
{
    private DateTime $currentDate;

    private DateTime $start;

    private DateTime $end;

    private Unit $interval;

    private int $key;

    public function __construct(DateTime $start, DateTime $end, Unit $interval)
    {
        $this->start = $start;
        $this->end = $end;
        $this->interval = $interval;
        $this->currentDate = clone $start;
        $this->key = 0;
    }

    public function current() : DateTime
    {
        return $this->currentDate;
    }

    public function next() : DateTime
    {
        $this->currentDate = $this->currentDate->add($this->interval);
        $this->key++;

        return $this->currentDate;
    }

    public function key() : int
    {
        return $this->key;
    }

    public function valid() : bool
    {
        if ($this->start->toDateTimeImmutable() == $this->end->toDateTimeImmutable()) {
            return false;
        }

        if ($this->start->toDateTimeImmutable() > $this->end->toDateTimeImmutable()) {
            return $this->currentDate->toDateTimeImmutable() >= $this->end->toDateTimeImmutable();
        }

        return $this->currentDate->toDateTimeImmutable() <= $this->end->toDateTimeImmutable();
    }

    public function rewind() : void
    {
        $this->currentDate = clone $this->start;
        $this->key = 0;
    }
}