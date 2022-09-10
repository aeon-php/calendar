<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\RelativeTimeUnit;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class Year
{
    private int $year;

    private YearMonths $months;

    public function __construct(int $year)
    {
        $this->year = $year;
        $this->months = new YearMonths($this);
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        return new self((int) $dateTime->format('Y'));
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromString(string $date) : self
    {
        try {
            if (\is_numeric($date)) {
                return new self((int) $date);
            }

            return self::fromDateTime(new \DateTimeImmutable($date));
        } catch (\Exception $e) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid year format.");
        }
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
     * @return array{year:int}
     */
    public function __serialize() : array
    {
        return [
            'year' => $this->year,
        ];
    }

    /**
     * @param array{year:int} $data
     */
    public function __unserialize(array $data) : void
    {
        $this->year = $data['year'];
        $this->months = new YearMonths($this);
    }

    public function toString() : string
    {
        return (string) $this->year;
    }

    public function january() : Month
    {
        return $this->months()->byNumber(1);
    }

    public function february() : Month
    {
        return $this->months()->byNumber(2);
    }

    public function march() : Month
    {
        return $this->months()->byNumber(3);
    }

    public function april() : Month
    {
        return $this->months()->byNumber(4);
    }

    public function may() : Month
    {
        return $this->months()->byNumber(5);
    }

    public function june() : Month
    {
        return $this->months()->byNumber(6);
    }

    public function july() : Month
    {
        return $this->months()->byNumber(7);
    }

    public function august() : Month
    {
        return $this->months()->byNumber(8);
    }

    public function september() : Month
    {
        return $this->months()->byNumber(9);
    }

    public function october() : Month
    {
        return $this->months()->byNumber(10);
    }

    public function november() : Month
    {
        return $this->months()->byNumber(11);
    }

    public function december() : Month
    {
        return $this->months()->byNumber(12);
    }

    public function months() : YearMonths
    {
        return $this->months;
    }

    public function number() : int
    {
        return $this->year;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `add` instead. Will be removed with 2.0
     */
    public function plus(int $years) : self
    {
        return $this->add($years);
    }

    public function add(int $years) : self
    {
        return new self($this->year + $years);
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `sub` instead. Will be removed with 2.0
     */
    public function minus(int $years) : self
    {
        return $this->sub($years);
    }

    public function sub(int $years) : self
    {
        return new self($this->year - $years);
    }

    public function next() : self
    {
        return new self($this->year + 1);
    }

    public function previous() : self
    {
        return new self($this->year - 1);
    }

    public function numberOfMonths() : int
    {
        return 12;
    }

    public function numberOfDays() : int
    {
        return $this->isLeap() ? 366 : 365;
    }

    public function quarter(int $number) : Quarter
    {
        switch ($number) {
            case 1:
                return new Quarter($number, $this->months()->slice(0, 3));
            case 2:
                return new Quarter($number, $this->months()->slice(3, 3));
            case 3:
                return new Quarter($number, $this->months()->slice(6, 3));
            case 4:
                return new Quarter($number, $this->months()->slice(9, 3));

            default:
                throw new InvalidArgumentException('Quarter number must be greater or equal 1 and less or equal than 4');
        }
    }

    /**
     * @psalm-param pure-callable(Day $day) : void $iterator
     *
     * @param callable(Day $day) : void $iterator
     *
     * @return array<mixed>
     */
    public function mapDays(callable $iterator) : array
    {
        /** @psalm-suppress ImpureFunctionCall */
        return \array_map(
            $iterator,
            \array_merge(
                ...\array_map(
                    fn (int $month) : array => $this->months()->byNumber($month)->days()->all(),
                    \range(1, 12)
                )
            )
        );
    }

    /**
     * @psalm-param pure-callable(Day $day) : bool $iterator
     *
     * @param callable(Day $day) : bool $iterator
     *
     * @return Days
     */
    public function filterDays(callable $iterator) : Days
    {
        /** @psalm-suppress ImpureFunctionCall */
        return Days::fromArray(...\array_filter(
            \array_merge(
                ...\array_map(
                    fn (int $month) : array => $this->months()->byNumber($month)->days()->all(),
                    \range(1, 12)
                )
            ),
            $iterator
        ));
    }

    public function isLeap() : bool
    {
        return $this->year % 4 == 0 && ($this->year % 100 != 0 || $this->year % 400 == 0);
    }

    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        return new \DateTimeImmutable(\sprintf('%d-01-01 00:00:00.000000 UTC', $this->number()));
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $year) : bool
    {
        return $this->isEqualTo($year);
    }

    public function isEqualTo(self $year) : bool
    {
        return $this->number() === $year->number();
    }

    public function isBefore(self $year) : bool
    {
        return $this->number() < $year->number();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isBeforeOrEqualTo` instead. Will be removed with 2.0
     */
    public function isBeforeOrEqual(self $year) : bool
    {
        return $this->isBeforeOrEqualTo($year);
    }

    public function isBeforeOrEqualTo(self $year) : bool
    {
        return $this->number() <= $year->number();
    }

    public function isAfter(self $year) : bool
    {
        return $this->number() > $year->number();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isAfterOrEqualTo` instead. Will be removed with 2.0
     */
    public function isAfterOrEqual(self $year) : bool
    {
        return $this->isAfterOrEqualTo($year);
    }

    public function isAfterOrEqualTo(self $year) : bool
    {
        return $this->number() >= $year->number();
    }

    public function iterate(self $destination, Interval $interval) : Years
    {
        return $this->isAfter($destination)
            ? $this->since($destination, $interval)
            : $this->until($destination, $interval);
    }

    public function until(self $month, Interval $interval) : Years
    {
        if ($this->isAfter($month)) {
            throw new InvalidArgumentException(
                \sprintf(
                    '%d is after %d',
                    $this->number(),
                    $month->number(),
                )
            );
        }

        /**
         * @var array<DateTime> $years
         *
         * @psalm-suppress ImpureMethodCall
         * @psalm-suppress ImpureFunctionCall
         */
        $years = \iterator_to_array(
            new DateTimeIntervalIterator(
                $this->january()->firstDay()->midnight(TimeZone::UTC()),
                $month->january()->firstDay()->midnight(TimeZone::UTC()),
                RelativeTimeUnit::year(),
                $interval
            )
        );

        return new Years(
            ...\array_map(
                function (DateTime $dateTime) : self {
                    return $dateTime->year();
                },
                $years
            )
        );
    }

    public function since(self $month, Interval $interval) : Years
    {
        if ($this->isBefore($month)) {
            throw new InvalidArgumentException(
                \sprintf(
                    '%d is before %d',
                    $this->number(),
                    $month->number(),
                )
            );
        }

        /**
         * @var array<DateTime> $years
         *
         * @psalm-suppress ImpureMethodCall
         * @psalm-suppress ImpureFunctionCall
         */
        $years = \iterator_to_array(
            new DateTimeIntervalIterator(
                $this->january()->firstDay()->midnight(TimeZone::UTC()),
                $month->january()->firstDay()->midnight(TimeZone::UTC()),
                RelativeTimeUnit::year()->toNegative(),
                $interval
            )
        );

        return new Years(
            ...\array_map(
                function (DateTime $dateTime) : self {
                    return $dateTime->year();
                },
                \array_reverse($years)
            )
        );
    }

    public function distance(self $to) : TimeUnit
    {
        return (new TimePeriod($this->january()->firstDay()->midnight(TimeZone::UTC()), $to->january()->firstDay()->midnight(TimeZone::UTC())))->distance();
    }

    public function compareTo(self $year) : int
    {
        if ($this->isEqualTo($year)) {
            return 0;
        }

        return $this->isBefore($year)
            ? -1
            : 1;
    }
}
