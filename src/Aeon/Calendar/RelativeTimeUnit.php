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

    public static function month() : self
    {
        return new self(1, null);
    }

    public static function months(int $number) : self
    {
        return new self($number, null);
    }

    public static function years(int $number) : self
    {
        return new self(null, $number);
    }

    public static function year() : self
    {
        return new self(null, 1);
    }

    public function toDateInterval() : \DateInterval
    {
        return new \DateInterval(\sprintf('P%dY%dM', $this->years ? $this->years : 0, $this->months ? $this->months : 0));
    }
}
