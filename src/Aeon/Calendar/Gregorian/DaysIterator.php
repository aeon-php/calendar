<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @phpstan-ignore-next-line
 */
final class DaysIterator extends \IteratorIterator
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

    public function current() : ?Day
    {
        /** @var null|\DateTimeInterface|Day $current */
        $current = parent::current();

        if ($current === null) {
            return null;
        }

        if ($current instanceof Day) {
            return $current;
        }

        return Day::fromDateTime($current);
    }

    public function reverse() : self
    {
        /** @phpstan-ignore-next-line  */
        return new self(new \ArrayIterator(\array_reverse(\iterator_to_array($this))));
    }
}
