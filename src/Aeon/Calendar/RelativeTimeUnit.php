<?php

declare(strict_types=1);

namespace Aeon\Calendar;

/**
 * @psalm-immutable
 */
final class RelativeTimeUnit implements Unit
{
    private ?int $months;

    private ?int $years;

    private function __construct(?int $months = null, ?int $years = null)
    {
        $this->months = $months;
        $this->years = $years;
    }

    /** @psalm-pure */
    public static function month() : self
    {
        return new self(1, null);
    }

    /** @psalm-pure */
    public static function months(int $number) : self
    {
        return new self($number, null);
    }

    /** @psalm-pure */
    public static function years(int $number) : self
    {
        return new self(null, $number);
    }

    /** @psalm-pure */
    public static function year() : self
    {
        return new self(null, 1);
    }

    public function toDateInterval() : \DateInterval
    {
        return new \DateInterval(\sprintf('P%dY%dM', $this->inYears() ? $this->inYears() : 0, $this->inCalendarMonths() ? $this->inCalendarMonths() : 0));
    }

    public function inCalendarMonths() : int
    {
        if ($this->months === null) {
            return 0;
        }

        return \abs($this->months % 12);
    }

    /**
     * @psalm-suppress PossiblyNullOperand
     * @psalm-suppress InvalidNullableReturnType
     */
    public function inYears() : int
    {
        if ($this->years !== null) {
            return $this->years;
        }

        return (int) \floor($this->months / 12);
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InvalidNullableReturnType
     */
    public function inMonths() : int
    {
        if ($this->years !== null) {
            return $this->years * 12;
        }

        /**
         * @phpstan-ignore-next-line
         */
        return $this->months;
    }
}
