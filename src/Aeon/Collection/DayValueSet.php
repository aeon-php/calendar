<?php

declare(strict_types=1);

namespace Aeon\Collection;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Days;
use Aeon\Calendar\Gregorian\Interval;

/**
 * @psalm-immutable
 */
final class DayValueSet implements \Countable
{
    /**
     * @var array<string, DayValue>
     */
    private array $dayValues;

    public function __construct(DayValue ...$dayValues)
    {
        $indexedDayValues = [];

        foreach ($dayValues as $dayValue) {
            if (\array_key_exists($dayValue->day()->toString(), $indexedDayValues)) {
                throw new InvalidArgumentException('Set does not allow duplicated days, day ' . $dayValue->day()->toString() . ' is duplicated');
            }

            $indexedDayValues[$dayValue->day()->toString()] = $dayValue;
        }

        $this->dayValues = $indexedDayValues;
    }

    /**
     * @psalm-pure
     */
    public static function createEmpty(Day $start, Day $end) : self
    {
        return new self(
            ...$start->until(
                $end,
                Interval::closed()
            )->map(fn (Day $day) : DayValue => DayValue::createEmpty($day))
        );
    }

    /**
     * @psalm-pure
     *
     * @param mixed $value
     */
    public static function createWith(Day $start, Day $end, $value) : self
    {
        return new self(
            ...$start->until(
                $end,
                Interval::closed()
            )->map(fn (Day $day) : DayValue => new DayValue($day, $value))
        );
    }

    /**
     * @param mixed $value
     * @psalm-suppress PossiblyNullReference
     */
    public function fillMissingWith($value) : self
    {
        if (!$this->count()) {
            return $this;
        }

        $sortedDayValues = $this->sortAscending();

        /* @phpstan-ignore-next-line  */
        $daysRange = $sortedDayValues->first()->day()->until($sortedDayValues->last()->day(), Interval::closed());

        foreach ($daysRange->all() as $nextDay) {
            if (!$sortedDayValues->has($nextDay)) {
                $sortedDayValues = $sortedDayValues->put(new DayValue($nextDay, $value));
            }
        }

        return $sortedDayValues;
    }

    public function put(DayValue ...$dayValues) : self
    {
        $currentDayValues = $this->dayValues;

        foreach ($dayValues as $dayValue) {
            $currentDayValues[$dayValue->day()->toString()] = $dayValue;
        }

        return new self(...\array_values($currentDayValues));
    }

    public function remove(Day ...$days) : self
    {
        $currentDayValues = $this->dayValues;

        foreach ($days as $day) {
            if (\array_key_exists($day->toString(), $this->dayValues)) {
                unset($currentDayValues[$day->toString()]);
            }
        }

        return new self(...\array_values($currentDayValues));
    }

    public function has(Day $day) : bool
    {
        return \array_key_exists($day->toString(), $this->dayValues);
    }

    public function get(Day $day) : DayValue
    {
        if (!\array_key_exists($day->toString(), $this->dayValues)) {
            throw new InvalidArgumentException('There is no value for day ' . $day->toString());
        }

        return $this->dayValues[$day->toString()];
    }

    public function first() : ?DayValue
    {
        if (!$this->count()) {
            return null;
        }

        /* @phpstan-ignore-next-line */
        return \current($this->dayValues);
    }

    public function last() : ?DayValue
    {
        if (!$this->count()) {
            return null;
        }

        /* @phpstan-ignore-next-line */
        return \end($this->dayValues);
    }

    public function count() : int
    {
        return \count($this->dayValues);
    }

    /**
     * @psalm-param pure-callable(DayValue $dayValue) : bool $callback
     *
     * @param callable(DayValue $dayValue) : bool $callback
     */
    public function filter(callable $callback) : self
    {
        return new self(...\array_values(\array_filter($this->dayValues, $callback)));
    }

    /**
     * @psalm-param pure-callable(DayValue $dayValue) : DayValue $callback
     *
     * @param callable(DayValue $dayValue) : DayValue $callback
     */
    public function map(callable $callback) : self
    {
        /** @var array<DayValue> $dayValues */
        $dayValues = \array_values(\array_map($callback, $this->dayValues));

        return new self(...$dayValues);
    }

    /**
     * @psalm-param pure-callable(mixed $initial, DayValue $nextDayValue) : mixed $callback
     *
     * @param callable(mixed $initial, DayValue $nextDayValue) : mixed $callback
     * @param null|mixed $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        return \array_reduce($this->dayValues, $callback, $initial);
    }

    public function toDays() : Days
    {
        $days = [];

        foreach ($this->dayValues as $dayValue) {
            $days[] = $dayValue->day();
        }

        return new Days(...$days);
    }

    /**
     * @psalm-suppress MixedAssignment
     *
     * @return array<mixed>
     */
    public function values() : array
    {
        $values = [];

        foreach ($this->dayValues as $dayValue) {
            $values[] = $dayValue->value();
        }

        return $values;
    }

    public function sortAscending() : self
    {
        $values = $this->dayValues;

        \uasort(
            $values,
            function (DayValue $dayValueA, DayValue $dayValueB) : int {
                return $dayValueA->day()->toDateTimeImmutable() <=> $dayValueB->day()->toDateTimeImmutable();
            }
        );

        return new self(...\array_values($values));
    }

    public function sortDescending() : self
    {
        $values = $this->dayValues;

        \uasort(
            $values,
            function (DayValue $dayValueA, DayValue $dayValueB) : int {
                return $dayValueB->day()->toDateTimeImmutable() <=> $dayValueA->day()->toDateTimeImmutable();
            }
        );

        return new self(...\array_values($values));
    }

    /**
     * A form of slice that returns the first n elements.
     */
    public function take(int $days) : self
    {
        if ($days < 0) {
            throw new InvalidArgumentException('Take does not accept negative number of days');
        }

        return new self(...\array_values(\array_slice($this->dayValues, 0, $days)));
    }

    /**
     * Return a sub-sequence of the set between the given offset and given number of days.
     */
    public function slice(int $offset, int $days) : self
    {
        if ($offset < 0) {
            throw new InvalidArgumentException('Slice does not accept negative offset');
        }

        if ($days < 0) {
            throw new InvalidArgumentException('Slice does not accept negative days');
        }

        return new self(...\array_values(\array_slice($this->dayValues, $offset, $days)));
    }

    /**
     * A form of slice that returns all but the first n elements.
     */
    public function drop(int $offset) : self
    {
        if ($offset < 0) {
            throw new InvalidArgumentException('Drop does not accept negative offset');
        }

        return new self(...\array_values(\array_slice($this->dayValues, $offset, \count($this->dayValues))));
    }
}
