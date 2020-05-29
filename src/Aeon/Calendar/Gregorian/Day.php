<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Gregorian\Day\WeekDay;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class Day
{
    private Month $month;

    private int $number;

    public function __construct(Month $month, int $number)
    {
        Assert::greaterThan($number, 0);
        Assert::lessThanEq($number, $month->numberOfDays());

        $this->number = $number;
        $this->month = $month;
    }

    /**
     * @return array{year: int, month:int, day: int}
     */
    public function __debugInfo() : array
    {
        return [
            'year' => $this->month->year()->number(),
            'month' => $this->month->number(),
            'day' => $this->number,
        ];
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTime(\DateTimeImmutable $dateTime) : self
    {
        return new self(
            new Month(
                new Year((int) $dateTime->format('Y')),
                (int) $dateTime->format('m')
            ),
            (int) $dateTime->format('d')
        );
    }

    /**
     * @throws \Exception
     * @psalm-pure
     */
    public static function fromString(string $date) : self
    {
        return self::fromDateTime(new \DateTimeImmutable($date));
    }

    public function previous() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('-1 day'));
    }

    public function next() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('+1 day'));
    }

    public function midnight() : DateTime
    {
        return new DateTime($this, new Time(0, 0, 0, 0));
    }

    public function noon() : DateTime
    {
        return new DateTime($this, new Time(12, 0, 0, 0));
    }

    public function endOfDay() : DateTime
    {
        return new DateTime($this, new Time(23, 59, 59, 999999));
    }

    public function month() : Month
    {
        return $this->month;
    }

    public function year() : Year
    {
        return $this->month()->year();
    }

    public function number() : int
    {
        return $this->number;
    }

    public function weekDay() : WeekDay
    {
        return new WeekDay((int) $this->toDateTimeImmutable()->format('N'));
    }

    /**
     * Week of year starting from 1
     */
    public function weekOfYear() : int
    {
        return (int) $this->toDateTimeImmutable()->format('W');
    }

    /**
     * Day of year starting from 1
     */
    public function dayOfYear() : int
    {
        return ((int) $this->toDateTimeImmutable()->format('z')) + 1;
    }

    public function isWeekend() : bool
    {
        return $this->weekDay()->isWeekend();
    }

    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (new \DateTimeImmutable('now'))->setDate($this->month()->year()->number(), $this->month()->number(), $this->number());
    }

    public function format(string $format) : string
    {
        return $this->toDateTimeImmutable()->format($format);
    }

    public function equals(Day $day) : bool
    {
        return $this->year()->number() === $day->year()->number()
            && $this->month()->number() === $day->month()->number()
            && $this->number() === $day->number();
    }
}
