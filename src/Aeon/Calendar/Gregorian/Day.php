<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Day\WeekDay;

/**
 * @psalm-immutable
 */
final class Day
{
    private Month $month;

    private int $number;

    public function __construct(Month $month, int $number)
    {
        if ($number <= 0 || $number > $month->numberOfDays()) {
            throw new InvalidArgumentException('Day number must be greater or equal 1 and less or equal than ' . $month->numberOfDays());
        }

        $this->number = $number;
        $this->month = $month;
    }

    /**
     * @psalm-pure
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
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

    public function previous() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('-1 day'));
    }

    public function next() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('+1 day'));
    }

    public function midnight(TimeZone $timeZone) : DateTime
    {
        return new DateTime($this, new Time(0, 0, 0, 0), $timeZone);
    }

    public function noon(TimeZone $timeZone) : DateTime
    {
        return new DateTime($this, new Time(12, 0, 0, 0), $timeZone);
    }

    public function endOfDay(TimeZone $timeZone) : DateTime
    {
        return new DateTime($this, new Time(23, 59, 59, 999999), $timeZone);
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
     * Week of year starting from 1.
     */
    public function weekOfYear() : int
    {
        return (int) $this->toDateTimeImmutable()->format('W');
    }

    /**
     * Week of year starting from 1.
     */
    public function weekOfMonth() : int
    {
        return $this->weekOfYear() - $this->month()->days()->first()->weekOfYear() + 1;
    }

    /**
     * Day of year starting from 1.
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
        return (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
            ->setDate(
                $this->month()->year()->number(),
                $this->month()->number(),
                $this->number()
            )
            ->setTime(0, 0, 0, 0);
    }

    public function format(string $format) : string
    {
        return $this->toDateTimeImmutable()->format($format);
    }

    public function equals(self $day) : bool
    {
        return $this->year()->number() === $day->year()->number()
            && $this->month()->number() === $day->month()->number()
            && $this->number() === $day->number();
    }
}
