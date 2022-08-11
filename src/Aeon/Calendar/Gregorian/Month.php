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
    private const TOTAL_MONTHS = 12;

    private Year $year;

    private MonthDays $days;

    private int $number;

    private ?\DateTimeImmutable $dateTime;

    private bool $clean = true;

    public function __construct(Year $year, int $number)
    {
        if ($number <= 0 || $number > self::TOTAL_MONTHS) {
            throw new InvalidArgumentException('Month number must be greater or equal 1 and less or equal than 12');
        }

        $this->year = $year;
        $this->number = $number;
        $this->days = new MonthDays($this);
        $this->dateTime = null;
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
     * @psalm-suppress ImpureStaticProperty
     * @psalm-suppress PropertyTypeCoercion
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        $newMonth =  new self(
            new Year((int) $dateTime->format('Y')),
            (int) $dateTime->format('m')
        );

        $newMonth->dateTime = $dateTime instanceof \DateTime ? \DateTimeImmutable::createFromMutable($dateTime) : $dateTime;
        $newMonth->clean = false;

        return $newMonth;
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $date) : self
    {
        try {
            return self::fromDateTime(new \DateTimeImmutable($date));
        } catch (\Exception $e) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid month format.");
        }
    }

    /**
     * @return array{year: int, month: int}
     */
    public function __debugInfo() : array
    {
        return [
            'year' => $this->year()->number(),
            'month' => $this->number(),
        ];
    }

    /**
     * @return array{year: Year, number: int}
     */
    public function __serialize() : array
    {
        return [
            'year' => $this->year(),
            'number' => $this->number(),
        ];
    }

    /**
     * @param array{year: Year, number: int} $data
     */
    public function __unserialize(array $data) : void
    {
        $this->year = $data['year'];
        $this->number = $data['number'];
        $this->dateTime = null;
        $this->days = new MonthDays($this);
    }

    public function toString() : string
    {
        return $this->toDateTimeImmutable()->format('Y-m');
    }

    public function previous() : self
    {
        return $this->subMonths(1);
    }

    public function next() : self
    {
        return $this->addMonths(1);
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `add` instead. Will be removed with 2.0
     */
    public function plus(int $years, int $months) : self
    {
        return $this->add($years, $months);
    }

    public function add(int $years, int $months) : self
    {
        $month = $this;

        if ($months !== 0) {
            $month = $month->addMonths($months);
        }

        if ($years !== 0) {
            $month = $month->addYears($years);
        }

        return $month;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `sub` instead. Will be removed with 2.0
     */
    public function minus(int $years, int $months) : self
    {
        return $this->sub($years, $months);
    }

    public function sub(int $years, int $months) : self
    {
        $month = $this;

        if ($months !== 0) {
            $month = $month->subMonths($months);
        }

        if ($years !== 0) {
            $month = $month->subYears($years);
        }

        return $month;
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
        $years = (int) ($months / self::TOTAL_MONTHS);
        $monthsRemainder = $months % self::TOTAL_MONTHS;

        $year = $this->year->number() + $years;
        $month = $this->number() + $monthsRemainder;

        if ($month > self::TOTAL_MONTHS) {
            $year += ((int) ($month / self::TOTAL_MONTHS));
            $month %= self::TOTAL_MONTHS;
        }

        if ($month === 0) {
            $month = 12;
        }

        return new self(new Year($year), $month);
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
        $years = (int) ($months / self::TOTAL_MONTHS);
        $monthsRemainder = $months % self::TOTAL_MONTHS;

        $year = $this->year->number() - $years;
        $month = $this->number() - $monthsRemainder;

        if ($month === 0) {
            $month = self::TOTAL_MONTHS;
            $year--;
        }

        if ($month < 0) {
            $month = self::TOTAL_MONTHS - \abs($month);
            $year--;
        }

        return new self(new Year($year), $month);
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
        return new self($this->year->add($years), $this->number);
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
        return new self($this->year->sub($years), $this->number);
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
        return 31 - (($this->number == 2) ?
                (3 - (int) $this->year->isLeap()) : (($this->number - 1) % 7 % 2));
    }

    public function shortName() : string
    {
        return $this->toDateTimeImmutable()->format('M');
    }

    public function name() : string
    {
        return $this->toDateTimeImmutable()->format('F');
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress InvalidNullableReturnType
     */
    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        if ($this->dateTime === null || $this->clean === false) {
            $this->dateTime = new \DateTimeImmutable(\sprintf('%d-%d-01 00:00:00.000000 UTC', $this->year()->number(), $this->number()));
            $this->clean = true;
        }

        return $this->dateTime;
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

        return Months::fromDateTimeIterator(
            new DateTimeIntervalIterator(
                $this->firstDay()->midnight(TimeZone::UTC()),
                $month->firstDay()->midnight(TimeZone::UTC()),
                RelativeTimeUnit::month(),
                $interval
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

        return Months::fromDateTimeIterator(
            new DateTimeIntervalIterator(
                $month->firstDay()->midnight(TimeZone::UTC()),
                $this->firstDay()->midnight(TimeZone::UTC()),
                RelativeTimeUnit::month(),
                $interval
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
