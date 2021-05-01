<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @phpstan-ignore-next-line
 */
final class MonthsIterator extends \IteratorIterator
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
    public static function fromDateTimeIterator(DateTimeIntervalIterator $iterator) : self
    {
        return new self($iterator);
    }

    public function current() : ?Month
    {
        /** @var null|DateTime|Month $current */
        $current = parent::current();

        if ($current === null) {
            return null;
        }

        if ($current instanceof Month) {
            return $current;
        }

        return $current->month();
    }

    public function reverse() : self
    {
        /** @phpstan-ignore-next-line  */
        return new self(new \ArrayIterator(\array_reverse(\iterator_to_array($this))));
    }
}
