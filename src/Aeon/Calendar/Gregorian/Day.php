<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Day\WeekDay;
use Aeon\Calendar\RelativeTimeUnit;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class Day
{
    private Month $month;

    private int $number;

    private ?\DateTimeImmutable $dateTime;

    public function __construct(Month $month, int $number)
    {
        if ($number <= 0 || $number > $month->numberOfDays()) {
            throw new InvalidArgumentException('Day number must be greater or equal 1 and less or equal than ' . $month->numberOfDays());
        }

        $this->number = $number;
        $this->month = $month;
        $this->dateTime = null;
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
        [$year, $month, $day] = \sscanf($dateTime->format('Y-m-d'), '%d-%d-%d');

        return new self(
            new Month(
                new Year((int) $year),
                (int) $month
            ),
            (int) $day
        );
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $date) : self
    {
        $dateNormalized = \trim(\strtolower($date));
        $dateParts = \date_parse($date);

        if (!\is_array($dateParts)) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid day format.");
        }

        if ($dateParts['error_count'] > 0) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid day format.");
        }

        if (isset($dateParts['relative']) || \in_array($dateNormalized, ['midnight', 'noon', 'now', 'today'], true)) {
            return self::fromDateTime(new \DateTimeImmutable($date));
        }

        if (!\is_int($dateParts['year']) || !\is_int($dateParts['month']) || !\is_int($dateParts['day'])) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid day format.");
        }

        return new self(new Month(new Year($dateParts['year']), $dateParts['month']), $dateParts['day']);
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
     * @return array{month: Month, number: int}
     */
    public function __serialize() : array
    {
        return [
            'month' => $this->month,
            'number' => $this->number,
        ];
    }

    /**
     * @param array{month: Month, number: int, dateTime: ?\DateTimeInterface} $data
     */
    public function __unserialize(array $data) : void
    {
        $this->month = $data['month'];
        $this->number = $data['number'];
        $this->dateTime = null;
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
        $dateTime = $this->midnight(TimeZone::UTC());

        if ($years !== 0) {
            $dateTime = $dateTime->add(RelativeTimeUnit::years($years));
        }

        if ($months !== 0) {
            $dateTime = $dateTime->add(RelativeTimeUnit::months($months));
        }

        if ($days !== 0) {
            $dateTime = $dateTime->add(TimeUnit::days($days));
        }

        return $dateTime->day();
    }

    public function minus(int $years, int $months, int $days) : self
    {
        $dateTime = $this->midnight(TimeZone::UTC());

        if ($years !== 0) {
            $dateTime = $dateTime->sub(RelativeTimeUnit::years($years));
        }

        if ($months !== 0) {
            $dateTime = $dateTime->sub(RelativeTimeUnit::months($months));
        }

        if ($days !== 0) {
            $dateTime = $dateTime->sub(TimeUnit::days($days));
        }

        return $dateTime->day();
    }

    public function plusDays(int $days) : self
    {
        return $this->midnight(TimeZone::UTC())->add(TimeUnit::days($days))->day();
    }

    public function minusDays(int $days) : self
    {
        return $this->midnight(TimeZone::UTC())->sub(TimeUnit::days($days))->day();
    }

    public function plusMonths(int $months) : self
    {
        return $this->midnight(TimeZone::UTC())->add(RelativeTimeUnit::months($months))->day();
    }

    public function minusMonths(int $months) : self
    {
        return $this->midnight(TimeZone::UTC())->sub(RelativeTimeUnit::months($months))->day();
    }

    public function plusYears(int $years) : self
    {
        return $this->midnight(TimeZone::UTC())->add(RelativeTimeUnit::years($years))->day();
    }

    public function minusYears(int $years) : self
    {
        return $this->midnight(TimeZone::UTC())->sub(RelativeTimeUnit::years($years))->day();
    }

    public function previous() : self
    {
        return $this->midnight(TimeZone::UTC())->sub(TimeUnit::day())->day();
    }

    public function next() : self
    {
        return $this->midnight(TimeZone::UTC())->add(TimeUnit::day())->day();
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

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress NullableReturnStatement
     */
    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        if ($this->dateTime === null) {
            $this->dateTime = new \DateTimeImmutable(\sprintf('%d-%d-%d 00:00:00.000000 UTC', $this->month()->year()->number(), $this->month()->number(), $this->number()));
        }

        return $this->dateTime;
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

        return Days::fromDateTimeIterator(
            new DateTimeIntervalIterator(
                $this->midnight(TimeZone::UTC()),
                $day->midnight(TimeZone::UTC()),
                TimeUnit::day(),
                $interval
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

        return Days::fromDateTimeIterator(
            new DateTimeIntervalIterator(
                $this->midnight(TimeZone::UTC()),
                $day->midnight(TimeZone::UTC()),
                TimeUnit::day()->toNegative(),
                $interval
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
