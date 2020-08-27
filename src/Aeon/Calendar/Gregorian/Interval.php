<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\TimeUnit;

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

    /**
     * @phpstan-ignore-next-line
     */
    public function toDatePeriod(DateTime $left, TimeUnit $timeUnit, DateTime $right) : \DatePeriod
    {
        if ($this->type === self::CLOSED) {
            return new \DatePeriod(
                $left->toDateTimeImmutable(),
                $timeUnit->toDateInterval(),
                $right->add($timeUnit)->toDateTimeImmutable()
            );
        }

        if ($this->type === self::LEFT_OPEN) {
            return new \DatePeriod(
                $left->add($timeUnit)->toDateTimeImmutable(),
                $timeUnit->toDateInterval(),
                $right->add($timeUnit)->toDateTimeImmutable()
            );
        }

        if ($this->type === self::RIGHT_OPEN) {
            return new \DatePeriod(
                $left->toDateTimeImmutable(),
                $timeUnit->toDateInterval(),
                $right->toDateTimeImmutable()
            );
        }

        return new \DatePeriod(
            $left->add($timeUnit)->toDateTimeImmutable(),
            $timeUnit->toDateInterval(),
            $right->toDateTimeImmutable()
        );
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function toDatePeriodBackward(DateTime $left, TimeUnit $timeUnit, DateTime $right) : \DatePeriod
    {
        if ($this->type === self::CLOSED) {
            return new \DatePeriod(
                $left->sub($timeUnit)->toDateTimeImmutable(),
                $timeUnit->toDateInterval(),
                $right->toDateTimeImmutable()
            );
        }

        if ($this->type === self::LEFT_OPEN) {
            return new \DatePeriod(
                $left->toDateTimeImmutable(),
                $timeUnit->toDateInterval(),
                $right->toDateTimeImmutable()
            );
        }

        if ($this->type === self::RIGHT_OPEN) {
            return new \DatePeriod(
                $left->sub($timeUnit)->toDateTimeImmutable(),
                $timeUnit->toDateInterval(),
                $right->sub($timeUnit)->toDateTimeImmutable()
            );
        }

        return new \DatePeriod(
            $left->toDateTimeImmutable(),
            $timeUnit->toDateInterval(),
            $right->sub($timeUnit)->toDateTimeImmutable()
        );
    }
}
