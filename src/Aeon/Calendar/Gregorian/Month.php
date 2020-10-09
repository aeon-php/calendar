<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\RelativeTimeUnit;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class Month
{
    private Year $year;

    private MonthDays $days;

    private int $number;

    public function __construct(Year $year, int $number)
    {
        if ($number <= 0 || $number > 12) {
            throw new InvalidArgumentException('Month number must be greater or equal 1 and less or equal than 12');
        }

        $this->year = $year;
        $this->number = $number;
        $this->days = new MonthDays($this);
    }

    /**
     * @psalm-pure
     */
    public static function create(int $year, int $month) : self
    {
        return new self(
            new Year($year),
            $month
        );
    }

    /**
     * @psalm-pure
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        return new self(
            new Year((int) $dateTime->format('Y')),
            (int) $dateTime->format('m')
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
     * @return array{year: int, month: int}
     */
    public function __debugInfo() : array
    {
        return [
            'year' => $this->year->number(),
            'month' => $this->number,
        ];
    }

    public function toString() : string
    {
        return $this->toDateTimeImmutable()->format('Y-m');
    }

    public function previous() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('-1 month'));
    }

    public function next() : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify('+1 month'));
    }

    public function plus(int $years, int $months) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('+%d months +%d years', $months, $years)));
    }

    public function minus(int $years, int $months) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('-%d months -%d years', $months, $years)));
    }

    public function plusMonths(int $months) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('+%d month', $months)));
    }

    public function minusMonths(int $months) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('-%d month', $months)));
    }

    public function plusYears(int $years) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('+%d years', $years)));
    }

    public function minusYears(int $years) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify(\sprintf('-%d years', $years)));
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

    public function days() : MonthDays
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

    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        return new \DateTimeImmutable(\sprintf('%d-%d-01 00:00:00.000000 UTC', $this->year()->number(), $this->number()));
    }

    public function iterate(self $destination, Interval $interval) : Months
    {
        return $this->isAfter($destination)
            ? $this->since($destination, $interval)
            : $this->until($destination, $interval);
    }

    public function until(self $month, Interval $interval) : Months
    {
        if ($this->isAfter($month)) {
            throw new InvalidArgumentException(
                \sprintf(
                    '%s %d is after %s %d',
                    $this->name(),
                    $this->year->number(),
                    $month->name(),
                    $month->year->number(),
                )
            );
        }

        return new Months(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) : self {
                    return self::fromDateTime($dateTimeImmutable);
                },
                \iterator_to_array(
                    $interval->toDatePeriod(
                        $this->firstDay()->midnight(TimeZone::UTC()),
                        RelativeTimeUnit::month(),
                        $month->firstDay()->midnight(TimeZone::UTC())
                    )
                )
            )
        );
    }

    public function since(self $month, Interval $interval) : Months
    {
        if ($this->isBefore($month)) {
            throw new InvalidArgumentException(
                \sprintf(
                    '%s %d is before %s %d',
                    $this->name(),
                    $this->year->number(),
                    $month->name(),
                    $month->year->number(),
                )
            );
        }

        return new Months(
            ...\array_map(
                function (\DateTimeImmutable $dateTimeImmutable) : self {
                    return self::fromDateTime($dateTimeImmutable);
                },
                \array_reverse(
                    \iterator_to_array(
                        $interval->toDatePeriodBackward(
                            $month->firstDay()->midnight(TimeZone::UTC()),
                            RelativeTimeUnit::month(),
                            $this->firstDay()->midnight(TimeZone::UTC())
                        )
                    )
                )
            )
        );
    }

    public function isEqual(self $month) : bool
    {
        return $this->number() == $month->number()
            && $this->year()->isEqual($month->year());
    }

    public function isBefore(self $month) : bool
    {
        if ($this->year()->isBefore($month->year())) {
            return true;
        }

        if ($this->year()->isAfter($month->year())) {
            return false;
        }

        return $this->number() < $month->number();
    }

    public function isBeforeOrEqual(self $month) : bool
    {
        if ($this->year()->isBefore($month->year())) {
            return true;
        }

        if ($this->year()->isAfter($month->year())) {
            return false;
        }

        return $this->number() <= $month->number();
    }

    public function isAfter(self $month) : bool
    {
        if ($this->year()->isAfter($month->year())) {
            return true;
        }

        if ($this->year()->isBefore($month->year())) {
            return false;
        }

        return $this->number() > $month->number();
    }

    public function isAfterOrEqual(self $month) : bool
    {
        if ($this->year()->isAfter($month->year())) {
            return true;
        }

        if ($this->year()->isBefore($month->year())) {
            return false;
        }

        return $this->number() >= $month->number();
    }

    public function distance(self $to) : TimeUnit
    {
        return (new TimePeriod($this->firstDay()->midnight(TimeZone::UTC()), $to->firstDay()->midnight(TimeZone::UTC())))->distance();
    }

    public function quarter() : Quarter
    {
        return $this->year->quarter((int) \ceil($this->number / 3));
    }
}
