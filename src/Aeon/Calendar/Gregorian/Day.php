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
     *
     * @psalm-suppress PossiblyNullArrayAccess
     * @psalm-suppress PossiblyNullArgument
     * @psalm-suppress ImpureMethodCall
     * @psalm-suppress PossiblyInvalidArgument
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        /**
         * @phpstan-ignore-next-line
         */
        [$year, $month, $day] = \sscanf($dateTime->format('Y-m-d'), '%d-%d-%d');

        /** @phpstan-ignore-next-line */
        return new self(new Month(new Year($year), $month), $day, );
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromString(string $date) : self
    {
        try {
            return self::fromDateTime(new \DateTimeImmutable($date));
        } catch (\Exception $e) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid day format.");
        }
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
     * @param array{month: Month, number: int} $data
     */
    public function __unserialize(array $data) : void
    {
        $this->month = $data['month'];
        $this->number = $data['number'];
    }

    public function toString() : string
    {
        return $this->format('Y-m-d');
    }

    public function timeBetween(self $day) : TimeUnit
    {
        return TimeUnit::seconds(\abs(($this->toDateTimeImmutable()->getTimestamp() - $day->toDateTimeImmutable()->getTimestamp())));
    }

    /** @deprecated Use `add` instead. Will be removed with 2.0 */
    public function plus(int $years, int $months, int $days) : self
    {
        return $this->add($years, $months, $days);
    }

    public function add(int $years, int $months, int $days) : self
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

    /** @deprecated Use `sub` instead. Will be removed with 2.0 */
    public function minus(int $years, int $months, int $days) : self
    {
        return $this->sub($years, $months, $days);
    }

    public function sub(int $years, int $months, int $days) : self
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

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `addDays` instead. Will be removed with 2.0
     */
    public function plusDays(int $days) : self
    {
        return $this->addDays($days);
    }

    public function addDays(int $days) : self
    {
        return $this->midnight(TimeZone::UTC())->add(TimeUnit::days($days))->day();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `subDays` instead. Will be removed with 2.0
     */
    public function minusDays(int $days) : self
    {
        return $this->subDays($days);
    }

    public function subDays(int $days) : self
    {
        return $this->midnight(TimeZone::UTC())->sub(TimeUnit::days($days))->day();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `addMonths` instead. Will be removed with 2.0
     */
    public function plusMonths(int $months) : self
    {
        return $this->addMonths($months);
    }

    public function addMonths(int $months) : self
    {
        return $this->midnight(TimeZone::UTC())->add(RelativeTimeUnit::months($months))->day();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `subMonths` instead. Will be removed with 2.0
     */
    public function minusMonths(int $months) : self
    {
        return $this->subMonths($months);
    }

    public function subMonths(int $months) : self
    {
        return $this->midnight(TimeZone::UTC())->sub(RelativeTimeUnit::months($months))->day();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `addYears` instead. Will be removed with 2.0
     */
    public function plusYears(int $years) : self
    {
        return $this->addYears($years);
    }

    public function addYears(int $years) : self
    {
        return $this->midnight(TimeZone::UTC())->add(RelativeTimeUnit::years($years))->day();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `subYears` instead. Will be removed with 2.0
     */
    public function minusYears(int $years) : self
    {
        return $this->subYears($years);
    }

    public function subYears(int $years) : self
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
        return $this->month->year();
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
        return $this->weekOfYear() - $this->month->days()->first()->weekOfYear() + 1;
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
        return new \DateTimeImmutable(\sprintf(
            '%d-%d-%d 00:00:00.000000 UTC',
            $this->month->year()->number(),
            $this->month->number(),
            $this->number
        ));
    }

    public function format(string $format) : string
    {
        return $this->toDateTimeImmutable()->format($format);
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $day) : bool
    {
        return $this->isEqualTo($day);
    }

    public function isEqualTo(self $day) : bool
    {
        return $this->number === $day->number()
            && $this->month->isEqualTo($day->month());
    }

    public function isBefore(self $day) : bool
    {
        if ($this->month->isBefore($day->month())) {
            return true;
        }

        if ($this->month->isAfter($day->month())) {
            return false;
        }

        return $this->number < $day->number();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isBeforeOrEqualTo` instead. Will be removed with 2.0
     */
    public function isBeforeOrEqual(self $day) : bool
    {
        return $this->isBeforeOrEqualTo($day);
    }

    public function isBeforeOrEqualTo(self $day) : bool
    {
        if ($this->month->isBefore($day->month())) {
            return true;
        }

        if ($this->month->isAfter($day->month())) {
            return false;
        }

        return $this->number <= $day->number();
    }

    public function isAfter(self $day) : bool
    {
        if ($this->month->isAfter($day->month())) {
            return true;
        }

        if ($this->month->isBefore($day->month())) {
            return false;
        }

        return $this->number > $day->number();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isAfterOrEqualTo` instead. Will be removed with 2.0
     */
    public function isAfterOrEqual(self $day) : bool
    {
        return $this->isAfterOrEqualTo($day);
    }

    public function isAfterOrEqualTo(self $day) : bool
    {
        if ($this->month->isAfter($day->month())) {
            return true;
        }

        if ($this->month->isBefore($day->month())) {
            return false;
        }

        return $this->number >= $day->number();
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
                    $this->number,
                    $this->month->name(),
                    $this->month->year()->number(),
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
                    $this->number,
                    $this->month->name(),
                    $this->month->year()->number(),
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
        return $this->year()->quarter((int) \ceil($this->month->number() / 3));
    }

    public function compareTo(self $day) : int
    {
        if ($this->isEqualTo($day)) {
            return 0;
        }

        return $this->isBefore($day)
            ? -1
            : 1;
    }
}
