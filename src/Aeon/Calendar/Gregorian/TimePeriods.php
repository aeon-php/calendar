<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @implements \IteratorAggregate<TimePeriod>
 */
final class TimePeriods implements \Countable, \IteratorAggregate
{
    /**
     * @var \Iterator<int|string, TimePeriod>
     */
    private \Iterator $periods;

    /**
     * @param \Iterator<int|string, TimePeriod> $periods
     */
    private function __construct(\Iterator $periods)
    {
        $this->periods = $periods;
    }

    public static function fromArray(TimePeriod ...$periods) : self
    {
        return new self(new \ArrayIterator($periods));
    }

    public static function fromIterator(TimePeriodsIterator $timePeriodsIterator) : self
    {
        return new self($timePeriodsIterator);
    }

    /**
     * @return array<TimePeriod>
     */
    public function all() : array
    {
        return \iterator_to_array($this->periods);
    }

    /**
     * @psalm-param pure-callable(TimePeriod $timePeriod) : void $iterator
     *
     * @param callable(TimePeriod $timePeriod) : void $iterator
     */
    public function each(callable $iterator) : void
    {
        foreach ($this->periods as $period) {
            $iterator($period);
        }
    }

    /**
     * @psalm-param pure-callable(TimePeriod $timePeriod) : mixed $iterator
     *
     * @param callable(TimePeriod $timePeriod) : mixed $iterator
     *
     * @return array<mixed>
     */
    public function map(callable $iterator) : array
    {
        return \array_map($iterator, $this->all());
    }

    /**
     * @psalm-suppress InvalidScalarArgument
     *
     * @psalm-param pure-callable(TimePeriod $timePeriod) : bool $iterator
     *
     * @param callable(TimePeriod $timePeriod) : bool $iterator
     *
     * @return self
     */
    public function filter(callable $iterator) : self
    {
        return new self(new \CallbackFilterIterator($this->periods, $iterator));
    }

    public function count() : int
    {
        return \iterator_count($this->periods);
    }

    /**
     * @return \Traversable<int|string, TimePeriod>
     */
    public function getIterator() : \Traversable
    {
        return $this->periods;
    }

    /**
     * Find all gaps between time periods.
     */
    public function gaps() : self
    {
        $periods = \array_map(
            function (TimePeriod $timePeriod) : TimePeriod {
                return $timePeriod->isBackward() ? $timePeriod->revert() : $timePeriod;
            },
            $this->sort()->all()
        );

        if (!\count($periods)) {
            return self::fromArray(...[]);
        }

        $gaps = [];
        $totalPeriod = \current($periods);

        while ($period = \next($periods)) {
            if ($totalPeriod->overlaps($period) || $totalPeriod->abuts($period)) {
                $totalPeriod = $totalPeriod->merge($period);
            } else {
                $gaps[] = new TimePeriod($totalPeriod->end(), $period->start());
                $totalPeriod = $period;
            }
        }

        return self::fromArray(...$gaps);
    }

    public function sort() : self
    {
        return $this->sortBy(TimePeriodsSort::asc());
    }

    public function sortBy(TimePeriodsSort $sort) : self
    {
        $periods = $this->all();

        \uasort(
            $periods,
            function (TimePeriod $timePeriodA, TimePeriod $timePeriodB) use ($sort) : int {
                if ($sort->byStartDate()) {
                    return $sort->isAscending()
                        ? $timePeriodA->start()->toDateTimeImmutable() <=> $timePeriodB->start()->toDateTimeImmutable()
                        : $timePeriodB->start()->toDateTimeImmutable() <=> $timePeriodA->start()->toDateTimeImmutable();
                }

                return $sort->isAscending()
                    ? $timePeriodA->end()->toDateTimeImmutable() <=> $timePeriodB->end()->toDateTimeImmutable()
                    : $timePeriodB->end()->toDateTimeImmutable() <=> $timePeriodA->end()->toDateTimeImmutable();
            }
        );

        return self::fromArray(...$periods);
    }

    public function first() : ?TimePeriod
    {
        $this->periods->rewind();

        return $this->periods->current();
    }

    public function last() : ?TimePeriod
    {
        $periods = $this->all();

        if (!\count($periods)) {
            return null;
        }

        return \end($periods);
    }

    public function add(TimePeriod ...$timePeriods) : self
    {
        return self::fromArray(...\array_merge($this->all(), $timePeriods));
    }

    public function merge(self $timePeriods) : self
    {
        return self::fromArray(...\array_merge($this->all(), $timePeriods->all()));
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $periods) : bool
    {
        return $this->isEqualTo($periods);
    }

    public function isEqualTo(self $periods) : bool
    {
        if ($periods->count() !== $this->count()) {
            return false;
        }

        $selfArray = \array_values($this->sort()->all());
        $periodsArray = \array_values($periods->sort()->all());

        foreach ($selfArray as $i => $timePeriod) {
            if (!$periodsArray[$i]->isEqualTo($timePeriod)) {
                return false;
            }
        }

        return true;
    }
}
