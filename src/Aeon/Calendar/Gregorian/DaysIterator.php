<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

final class DaysIterator extends \IteratorIterator
{
    /**
     * @param \Traversable<DateTime> $iterator
     */
    private function __construct(\Traversable $iterator)
    {
        parent::__construct($iterator);
    }

    /**
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public static function fromDateTimeIterator(DateTimeIntervalIterator $datePeriod) : self
    {
        return new self($datePeriod);
    }

    public function current() : ?Day
    {
        /** @var null|DateTime|Day $current */
        $current = parent::current();

        if ($current === null) {
            return null;
        }

        if ($current instanceof Day) {
            return $current;
        }

        return $current->day();
    }

    public function reverse() : self
    {
        /** @phpstan-ignore-next-line  */
        return new self(new \ArrayIterator(\array_reverse(\iterator_to_array($this))));
    }
}
