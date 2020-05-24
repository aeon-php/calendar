<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Gregorian;

use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class Month
{
    private Year $year;

    private Days $days;

    private int $number;

    public function __construct(Year $year, int $number)
    {
        Assert::greaterThan($number, 0);
        Assert::lessThanEq($number, 12);

        $this->year = $year;
        $this->number = $number;
        $this->days = new Days($this);
    }

    /**
     * @return array{year: int, month: int}
     */
    public function __debugInfo() : array
    {
        return [
            'year' => $this->year->number(),
            'month' => $this->number
        ];
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTime(\DateTimeImmutable $dateTime) : self
    {
        return new self(
            new Year((int) $dateTime->format('Y')),
            (int) $dateTime->format('m')
        );
    }

    public static function fromString(string $date) : self
    {
        return self::fromDateTime(new \DateTimeImmutable($date));
    }

    public function previous() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('-1 month'));
    }

    public function next() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('+1 month'));
    }

    public function firstDay() : Day
    {
        return $this->days()->first();
    }

    public function lastDay() : Day
    {
        return $this->days()->last();
    }

    public function number() : int
    {
        return $this->number;
    }

    public function year() : Year
    {
        return $this->year;
    }

    public function days(): Days
    {
        return $this->days;
    }

    public function numberOfDays() : int
    {
        return (int) $this->toDateTimeImmutable()->format('t');
    }

    public function shortName() : string
    {
        return $this->toDateTimeImmutable()->format('M');
    }

    public function name() : string
    {
        return $this->toDateTimeImmutable()->format('F');
    }

    private function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (new \DateTimeImmutable('now'))->setDate($this->year()->number(), $this->number(), 1);
    }
}