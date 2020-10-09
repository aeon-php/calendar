<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Day\WeekDay;
use Aeon\Calendar\TimeUnit;

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
     */
    public static function create(int $year, int $month, int $day) : self
    {
        return new self(
            new Month(
                new Year($year),
                $month
            ),
            $day
        );
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

    public function toString() : string
    {
        return $this->format('Y-m-d');
    }

    public function timeBetween(self $day) : TimeUnit
    {
        return TimeUnit::seconds(\abs(($this->toDateTimeImmutable()->getTimestamp() - $day->toDateTimeImmutable()->getTimestamp())));
    }

    public function plus(int $years, int $months, int $days) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('+%d days +%d months +%d years', $days, $months, $years)));
    }

    public function minus(int $years, int $months, int $days) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('-%d days -%d months -%d years', $days, $months, $years)));
    }

    public function plusDays(int $days) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('+%d days', $days)));
    }

    public function minusDays(int $days) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('-%d days', $days)));
    }

    public function plusMonths(int $months) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('+%d months', $months)));
    }

    public function minusMonths(int $months) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('-%d months', $months)));
    }

    public function plusYears(int $years) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('+%d years', $years)));
    }

    public function minusYears(int $years) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('-%d years', $years)));
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

    public function setTime(Time $time, TimeZone $timeZone) : DateTime
    {
        return new DateTime(
            $this,
            $time,
            $timeZone
        );
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
        return \intval($this->toDateTimeImmutable()->format('z')) + 1;
    }

    public function isWeekend() : bool
    {
        return $this->weekDay()->isWeekend();
    }

    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        return new \DateTimeImmutable(\sprintf('%d-%d-%d 00:00:00.000000 UTC', $this->month()->year()->number(), $this->month()->number(), $this->number()));
    }

    public function format(string $format) : string
    {
        return $this->toDateTimeImmutable()->format($format);
    }

    public function isEqual(self $day) : bool
    {
        return $this->number() === $day->number()
            && $this->month()->isEqual($day->month());
    }

    public function isBefore(self $day) : bool
    {
        if ($this->month()->isBefore($day->month())) {
            return true;
        }

        if ($this->month()->isAfter($day->month())) {
            return false;
        }

        return $this->number() < $day->number();
    }

    public function isBeforeOrEqual(self $day) : bool
    {
        if ($this->month()->isBefore($day->month())) {
            return true;
        }

        if ($this->month()->isAfter($day->month())) {
            return false;
        }

        return $this->number() <= $day->number();
    }

    public function isAfter(self $day) : bool
    {
        if ($this->month()->isAfter($day->month())) {
            return true;
        }

        if ($this->month()->isBefore($day->month())) {
            return false;
        }

        return $this->number() > $day->number();
    }

    public function isAfterOrEqual(self $day) : bool
    {
        if ($this->month()->isAfter($day->month())) {
            return true;
        }

        if ($this->month()->isBefore($day->month())) {
            return false;
        }

        return $this->number() >= $day->number();
    }

    public function iterate(self $destination, Interval $interval) : Days
    {
        return $this->isAfter($destination)
            ? $this->since($destination, $interval)
            : $this->until($destination, $interval);
    }

    public function until(self $day, Interval $interval) : Days
    {
        if ($this->isAfter($day)) {
            throw new InvalidArgumentException(
                \sprintf(
                    '%d %s %d is after %d %s %d',
                    $this->number(),
                    $this->month()->name(),
                    $this->month()->year()->number(),
                    $day->number(),
                    $day->month()->name(),
                    $day->month()->year()->number(),
                )
            );
        }

        return new Days(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) : self {
                    return self::fromDateTime($dateTimeImmutable);
                },
                \iterator_to_array(
                    $interval->toDatePeriod($this->midnight(TimeZone::UTC()), TimeUnit::day(), $day->midnight(TimeZone::UTC()))
                )
            )
        );
    }

    public function since(self $day, Interval $interval) : Days
    {
        if ($this->isBefore($day)) {
            throw new InvalidArgumentException(
                \sprintf(
                    '%d %s %d is before %d %s %d',
                    $this->number(),
                    $this->month()->name(),
                    $this->month()->year()->number(),
                    $day->number(),
                    $day->month()->name(),
                    $day->month()->year()->number(),
                )
            );
        }

        return new Days(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) : self {
                    return self::fromDateTime($dateTimeImmutable);
                },
                \array_reverse(
                    \iterator_to_array(
                        $interval->toDatePeriodBackward($day->midnight(TimeZone::UTC()), TimeUnit::day(), $this->midnight(TimeZone::UTC()))
                    )
                )
            )
        );
    }

    public function distance(self $to) : TimeUnit
    {
        return (new TimePeriod($this->midnight(TimeZone::UTC()), $to->midnight(TimeZone::UTC())))->distance();
    }

    public function quarter() : Quarter
    {
        return $this->year()->quarter((int) \ceil($this->month()->number() / 3));
    }
}
