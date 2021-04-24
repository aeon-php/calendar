<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @phpstan-ignore-next-line
 */
final class MonthsIterator extends \IteratorIterator
{
    /**
     * @param \Traversable<\DateTimeInterface> $iterator
     */
    private function __construct(\Traversable $iterator)
    {
        parent::__construct($iterator);
    }

    /**
     * @phpstan-ignore-next-line
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public static function fromDatePeriod(\DatePeriod $datePeriod) : self
    {
        return new self($datePeriod);
    }

    public function current() : ?Month
    {
        /** @var null|\DateTimeInterface|Month $current */
        $current = parent::current();

        if ($current === null) {
            return null;
        }

        if ($current instanceof Month) {
            return $current;
        }

        return Month::fromDateTime($current);
    }

    public function reverse() : self
    {
        /** @phpstan-ignore-next-line  */
        return new self(new \ArrayIterator(\array_reverse(\iterator_to_array($this))));
    }
}
