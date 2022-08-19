<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian\TimeZone;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class TimeOffset
{
    private const OFFSET_REGEXP = '/^(GMT)?([+-]?)(2[0-3]|[01][0-9]):?([0-5][0-9])$/';

    private bool $negative;

    private int $hours;

    private int $minutes;

    private function __construct(bool $negative, int $hours, int $minutes)
    {
        $this->negative = $negative;
        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    /** @psalm-pure */
    public static function UTC() : self
    {
        return new self(false, 0, 0);
    }

    /** @psalm-pure */
    public static function fromString(string $offset) : self
    {
        if (!\preg_match(self::OFFSET_REGEXP, $offset, $matches)) {
            throw new InvalidArgumentException("\"{$offset}\" is not a valid UTC Offset.");
        }

        return new self($matches[2] === '-', (int) $matches[3], (int) $matches[4]);
    }

    /** @psalm-pure */
    public static function isValid(string $offset) : bool
    {
        return (bool) \preg_match(self::OFFSET_REGEXP, $offset, $matches);
    }

    /** @psalm-pure */
    public static function fromTimeUnit(TimeUnit $timeUnit) : self
    {
        return self::fromString(
            ($timeUnit->isNegative() ? '-' : '+')
                . \str_pad((string) $timeUnit->inHoursAbs(), 2, '0', STR_PAD_LEFT)
                . \str_pad((string) $timeUnit->inTimeMinutes(), 2, '0', STR_PAD_LEFT)
        );
    }

    /**
     * @return array{hours: int, minutes: int, negative: bool}
     */
    public function __serialize() : array
    {
        return [
            'hours' => $this->hours,
            'minutes' => $this->minutes,
            'negative' => $this->negative,
        ];
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

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $timeOffset) : bool
    {
        return $this->isEqualTo($timeOffset);
    }

    public function isEqualTo(self $timeOffset) : bool
    {
        return $this->negative === $timeOffset->negative
            && $this->hours === $timeOffset->hours
            && $this->minutes === $timeOffset->minutes;
    }
}
