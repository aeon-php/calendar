<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\DateTimeIterator;
use Aeon\Calendar\TimeUnit;
use Aeon\Calendar\Unit;

/**
 * @psalm-immutable
 */
final class Interval
{
    public const CLOSED = 0;

    public const LEFT_OPEN = 1;

    public const RIGHT_OPEN = 2;

    public const OPEN = 4;

    private int $type;

    private function __construct(int $type)
    {
        $this->type = $type;
    }

    /**
     * A <= x <= B.
     *
     * @psalm-pure
     */
    public static function closed() : self
    {
        return new self(self::CLOSED);
    }

    /**
     * A <= x < B.
     *
     * @psalm-pure
     */
    public static function rightOpen() : self
    {
        return new self(self::RIGHT_OPEN);
    }

    /**
     * A < x <= B.
     *
     * @psalm-pure
     */
    public static function leftOpen() : self
    {
        return new self(self::LEFT_OPEN);
    }

    /**
     * A < x < B.
     *
     * @psalm-pure
     */
    public static function open() : self
    {
        return new self(self::OPEN);
    }

    public function isOpen() : bool
    {
        return $this->type === self::OPEN;
    }

    public function isLeftOpen() : bool
    {
        return $this->type === self::LEFT_OPEN || $this->type === self::OPEN;
    }

    public function isRightOpen() : bool
    {
        return $this->type === self::RIGHT_OPEN || $this->type === self::OPEN;
    }

    public function isClosed() : bool
    {
        return $this->type === self::CLOSED;
    }

    public function toIterator(DateTime $left, Unit $timeUnit, DateTime $right) : DateTimeIterator
    {
        if ($right->isEqual($left)) {
            return new DateTimeIterator($right, $left, TimeUnit::seconds(0));
        }

        if ($this->isOpen()) {
            return new DateTimeIterator($left->add($timeUnit), $right->sub($timeUnit), $timeUnit);
        }

        if ($this->isClosed()) {
            return new DateTimeIterator($left, $right, $timeUnit);
        }

        if ($this->isLeftOpen()) {
            return new DateTimeIterator($left->add($timeUnit), $right, $timeUnit);
        }

        return new DateTimeIterator($left, $right->sub($timeUnit), $timeUnit);
    }

    public function toIteratorBackward(DateTime $left, Unit $timeUnit, DateTime $right) : DateTimeIterator
    {
        if ($right->isEqual($left)) {
            return new DateTimeIterator($right, $left, TimeUnit::seconds(0));
        }

        if ($this->isOpen()) {
            return new DateTimeIterator($right->sub($timeUnit), $left->add($timeUnit), $timeUnit->toNegative());
        }

        if ($this->isClosed()) {
            return new DateTimeIterator($right, $left, $timeUnit->toNegative());
        }

        if ($this->isLeftOpen()) {
            return new DateTimeIterator($right, $left->add($timeUnit), $timeUnit->toNegative());
        }

        return new DateTimeIterator($right->sub($timeUnit), $left, $timeUnit->toNegative());
    }
}
