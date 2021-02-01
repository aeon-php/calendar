<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;

/**
 * @psalm-immutable
 * @implements \IteratorAggregate<int,TimePeriod>
 * @implements \ArrayAccess<int,TimePeriod>
 */
final class TimePeriods implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array<int, TimePeriod>
     */
    private array $periods;

    public function __construct(TimePeriod ...$periods)
    {
        $this->periods = $periods;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->all()[\intval($offset)]);
    }

    public function offsetGet($offset) : ?TimePeriod
    {
        return isset($this->all()[\intval($offset)]) ? $this->all()[\intval($offset)] : null;
    }

    public function offsetSet($offset, $value) : void
    {
        throw new \RuntimeException(__CLASS__ . ' is immutable.');
    }

    public function offsetUnset($offset) : void
    {
        throw new \RuntimeException(__CLASS__ . ' is immutable.');
    }

    /**
     * @return array<int, TimePeriod>
     */
    public function all() : array
    {
        return $this->periods;
    }

    /**
     * @psalm-param pure-callable(TimePeriod $timePeriod) : void $iterator
     *
     * @param callable(TimePeriod $timePeriod) : void $iterator
     */
    public function each(callable $iterator) : void
    {
        \array_map(
            $iterator,
            $this->all()
        );
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
     * @psalm-param pure-callable(TimePeriod $timePeriod) : bool $iterator
     *
     * @param callable(TimePeriod $timePeriod) : bool $iterator
     *
     * @return self
     */
    public function filter(callable $iterator) : self
    {
        return new self(...\array_filter($this->all(), $iterator));
    }

    public function count() : int
    {
        return \count($this->all());
    }

    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->all());
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

        $gaps = [];
        $totalPeriod = \current($periods);

        while ($period = \next($periods)) {
            try {
                $totalPeriod = $totalPeriod->merge($period);
            } catch (InvalidArgumentException $argumentException) {
                $gaps[] = new TimePeriod($totalPeriod->end(), $period->start());
                $totalPeriod = $period;
            }
        }

        return new self(...$gaps);
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

        return new self(...$periods);
    }

    public function first() : ?TimePeriod
    {
        $periods = $this->all();

        if (!\count($periods)) {
            return null;
        }

        return \current($periods);
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
        return new self(...\array_merge($this->periods, $timePeriods));
    }

    public function merge(self $timePeriods) : self
    {
        return new self(...\array_merge($this->periods, $timePeriods->periods));
    }
}
