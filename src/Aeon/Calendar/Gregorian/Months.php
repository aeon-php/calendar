<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 *
 * @implements \IteratorAggregate<Month>
 */
final class Months implements \Countable, \IteratorAggregate
{
    /**
     * @var \Iterator<int|string, Month>
     */
    private \Iterator $months;

    /**
     * @param \Iterator<int|string, Month> $months
     */
    private function __construct(\Iterator $months)
    {
        $this->months = $months;
    }

    /**
     * @psalm-pure
     */
    public static function fromArray(Month ...$days) : self
    {
        /** @psalm-suppress ImpureMethodCall */
        return new self(new \ArrayIterator($days));
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTimeIterator(DateTimeIntervalIterator $iterator) : self
    {
        /** @psalm-suppress ImpureMethodCall */
        return new self(MonthsIterator::fromDateTimeIterator($iterator));
    }

    /**
     * @return array<Month>
     *
     * @psalm-suppress ImpureFunctionCall
     */
    public function all() : array
    {
        return \iterator_to_array($this->months);
    }

    /**
     * @psalm-param pure-callable(Month $month) : mixed $iterator
     *
     * @param callable(Month $month) : mixed $iterator
     *
     * @return array<mixed>
     */
    public function map(callable $iterator) : array
    {
        return \array_map($iterator, $this->all());
    }

    /**
     * @psalm-param pure-callable(Month $month) : bool $iterator
     *
     * @param callable(Month $month) : bool $iterator
     */
    public function filter(callable $iterator) : self
    {
        return new self(new \CallbackFilterIterator($this->months, $iterator));
    }

    public function count() : int
    {
        return \iterator_count($this->months);
    }

    /**
     * @return \Traversable<int|string, Month>
     */
    public function getIterator() : \Traversable
    {
        return $this->months;
    }
}
