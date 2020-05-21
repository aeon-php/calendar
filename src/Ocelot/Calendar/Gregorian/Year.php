<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @psalm-external-mutation-free
 */
final class Year
{
    private int $year;

    private Months $months;

    public function __construct(int $year)
    {
        $this->year = $year;
        $this->months = new Months($this);
    }

    /**
     * @return array{year:int}
     */
    public function __debugInfo() : array
    {
        return [
            'year' => $this->year,
        ];
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTime(\DateTimeImmutable $dateTime) : self
    {
        return new self((int) $dateTime->format('Y'));
    }

    public static function fromString(string $date) : self
    {
        return self::fromDateTime(new \DateTimeImmutable($date));
    }

    public function january() : Month
    {
        return $this->months->byNumber(1);
    }

    public function february() : Month
    {
        return $this->months->byNumber(2);
    }

    public function march() : Month
    {
        return $this->months->byNumber(3);
    }

    public function april() : Month
    {
        return $this->months->byNumber(4);
    }

    public function may() : Month
    {
        return $this->months->byNumber(5);
    }

    public function june() : Month
    {
        return $this->months->byNumber(6);
    }

    public function july() : Month
    {
        return $this->months->byNumber(7);
    }

    public function august() : Month
    {
        return $this->months->byNumber(8);
    }

    public function september() : Month
    {
        return $this->months->byNumber(9);
    }

    public function october() : Month
    {
        return $this->months->byNumber(10);
    }

    public function november() : Month
    {
        return $this->months->byNumber(11);
    }

    public function december() : Month
    {
        return $this->months->byNumber(12);
    }

    public function months(): Months
    {
        return $this->months;
    }

    public function number() : int
    {
        return $this->year;
    }

    public function next() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('+1 year'));
    }

    public function previous() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('-1 year'));
    }

    public function numberOfMonths() : int
    {
        return 12;
    }

    public function numberOfDays() : int
    {
        return $this->isLeap() ? 366 : 365;
    }

    public function isLeap() : bool
    {
        return (bool) $this->toDateTimeImmutable()->format('L');
    }

    private function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (new \DateTimeImmutable('now'))->setDate($this->number(), 1, 1);
    }
}