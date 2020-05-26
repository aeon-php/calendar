<?php

declare(strict_types=1);

/*
 * This file is part of the Aeon time management framework for PHP.
 *
 * (c) Norbert Orzechowicz <contact@norbert.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aeon\Calendar\Gregorian\TimeZone;

use Aeon\Calendar\TimeUnit;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class TimeOffset
{
    private const OFFSET_REGEXP = '/^([)+-]?)(2[0-3]|[01][0-9]):?([0-5][0-9])$/';

    private bool $negative;

    private int $hours;

    private int $minutes;

    private function __construct(bool $negative, int $hours, int $minutes)
    {
        Assert::greaterThanEq($minutes, 0);
        Assert::lessThanEq($minutes, 60);

        $this->negative = $negative;
        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    /**
     * @psalm-pure
     */
    public static function UTC() : self
    {
        return new self(false, 0, 0);
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $offset) : self
    {
        Assert::regex($offset, self::OFFSET_REGEXP, "\"$offset\" is not a valid UTC Offset.");

        \preg_match(self::OFFSET_REGEXP, $offset, $matches);

        return new self($matches[1] === '-', (int) $matches[2], (int) $matches[3]);
    }

    public static function isValid(string $offset) : bool
    {
        return (bool) \preg_match(self::OFFSET_REGEXP, $offset, $matches);
    }

    /**
     * @psalm-pure
     */
    public static function fromTimeUnit(TimeUnit $timeUnit) : self
    {
        return self::fromString(
            $timeUnit->isNegative() ? "-" : "+"
                . \str_pad((string) $timeUnit->inHours(), 2, '0', STR_PAD_LEFT) . ':' . \str_pad((string) $timeUnit->inTimeMinutes(), 2, '0', STR_PAD_LEFT)
        );
    }

    public function toString() : string
    {
        return ($this->negative ? '-' : '+')
            . \str_pad((string) $this->hours, 2, '0', STR_PAD_LEFT) . ':' . \str_pad((string) $this->minutes, 2, '0', STR_PAD_LEFT);
    }

    public function toTimeUnit() : TimeUnit
    {
        return $this->negative
            ? TimeUnit::minutes($this->minutes)->add(TimeUnit::hours($this->hours))->invert()
            : TimeUnit::minutes($this->minutes)->add(TimeUnit::hours($this->hours));
    }

    public function toDateTimeZone() : \DateTimeZone
    {
        return new \DateTimeZone($this->toString());
    }

    public function isUTC() : bool
    {
        return $this->hours === 0 && $this->minutes === 0;
    }
}
