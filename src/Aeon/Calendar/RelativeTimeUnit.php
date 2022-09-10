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
        $dateInterval = new \DateInterval(\sprintf('P%dY%dM', $this->inYears() ? \abs($this->inYears()) : 0, $this->inCalendarMonths() ? \abs($this->inCalendarMonths()) : 0));

        if ($this->isNegative()) {
            /** @psalm-suppress ImpurePropertyAssignment */
            $dateInterval->invert = 1;
        }

        return $dateInterval;
    }

    public function invert() : self
    {
        if ($this->years) {
            return $this->isNegative() ? self::years(\abs($this->years)) : self::years(-$this->years);
        }

        /**
         * @psalm-suppress PossiblyNullArgument
         *
         * @phpstan-ignore-next-line
         */
        return $this->isNegative() ? self::months(\abs($this->months)) : self::months(-$this->months);
    }

    public function inCalendarMonths() : int
    {
        if ($this->months === null) {
            return 0;
        }

        return \abs($this->months % 12);
    }

    public function isNegative() : bool
    {
        return $this->years < 0 || $this->months < 0;
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

        /**
         * @psalm-suppress PossiblyNullArgument
         *
         * @phpstan-ignore-next-line
         */
        $years = (int) \floor(\abs($this->months) / 12);

        return $this->isNegative() ? -$years : $years;
    }

    public function toNegative() : self
    {
        if ($this->isNegative()) {
            return $this;
        }

        return $this->invert();
    }

    public function toPositive() : self
    {
        if (!$this->isNegative()) {
            return $this;
        }

        return $this->invert();
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
