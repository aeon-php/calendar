<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\DateTimeIterator;

/**
 * @phpstan-ignore-next-line
 */
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
     * @phpstan-ignore-next-line
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public static function fromDateTimeIterator(DateTimeIterator $datePeriod) : self
    {
        return new self($datePeriod);
    }

    public function current() : ?Day
    {
        /** @var null|Day|DateTime $current */
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
