<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\RelativeTimeUnit;
use Aeon\Calendar\TimeUnit;
use Aeon\Calendar\Unit;

/**
 * @psalm-immutable
 */
final class DateTime
{
    private Day $day;

    private Time $time;

    private TimeZone $timeZone;

    public function __construct(Day $day, Time $time, TimeZone $timeZone)
    {
        $this->day = $day;
        $this->time = $time;
        $this->timeZone = $timeZone;
    }

    /**
     * @psalm-pure
     */
    public static function create(int $year, int $month, int $day, int $hour, int $minute, int $second, int $microsecond = 0, string $timezone = 'UTC') : self
    {
        return new self(
            new Day(
                new Month(
                    new Year($year),
                    $month
                ),
                $day
            ),
            new Time($hour, $minute, $second, $microsecond),
            TimeZone::fromString($timezone)
        );
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall
     * @psalm-suppress ImpureStaticProperty
     * @psalm-suppress PropertyTypeCoercion
     * @psalm-suppress ImpurePropertyAssignment
     * @psalm-suppress InaccessibleProperty
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        $day = Day::fromDateTime($dateTime);
        $time = Time::fromDateTime($dateTime);
        $timeZone = TimeZone::fromDateTimeZone($dateTime->getTimezone());

        return new self(
            $day,
            $time,
            $timeZone,
        );
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureFunctionCall
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromString(string $date) : self
    {
        $currentPHPTimeZone = \date_default_timezone_get();
        \date_default_timezone_set('UTC');

        try {
            $dateTime = self::fromDateTime(new \DateTimeImmutable($date));
        } catch (\Exception $e) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid date time format.");
        }

        if ($currentPHPTimeZone !== 'UTC') {
            \date_default_timezone_set($currentPHPTimeZone);
        }

        return $dateTime;
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureFunctionCall
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromTimestampUnix(int $timestamp) : self
    {
        $currentPHPTimeZone = \date_default_timezone_get();

        \date_default_timezone_set('UTC');

        $dateTime = self::fromDateTime((new \DateTimeImmutable)->setTimestamp($timestamp));

        if ($currentPHPTimeZone !== 'UTC') {
            \date_default_timezone_set($currentPHPTimeZone);
        }

        return $dateTime;
    }

    public function __toString() : string
    {
        return $this->toISO8601();
    }

    /**
     * @return array{datetime: string, day: Day, time: Time, timeZone: TimeZone}
     */
    public function __debugInfo() : array
    {
        return [
            'datetime' => $this->toISO8601(),
            'day' => $this->day,
            'time' => $this->time,
            'timeZone' => $this->timeZone,
        ];
    }

    /**
     * @return array{day: Day, time: Time, timeZone: TimeZone}
     */
    public function __serialize() : array
    {
        return [
            'day' => $this->day,
            'time' => $this->time,
            'timeZone' => $this->timeZone,
        ];
    }

    /**
     * @param array{day: Day, time: Time, timeZone: TimeZone} $data
     */
    public function __unserialize(array $data) : void
    {
        $this->day = $data['day'];
        $this->time = $data['time'];
        $this->timeZone = $data['timeZone'];
    }

    public function year() : Year
    {
        return $this->month()->year();
    }

    public function month() : Month
    {
        return $this->day->month();
    }

    public function day() : Day
    {
        return $this->day;
    }

    public function time() : Time
    {
        return $this->time;
    }

    public function setTime(Time $time) : self
    {
        return new self(
            $this->day,
            $time,
            $this->timeZone
        );
    }

    public function setTimeIn(Time $time, TimeZone $timeZone) : self
    {
        return (new self(
            $this->day,
            $time,
            $this->timeZone
        ))->toTimeZone($timeZone)
            ->setTime($time);
    }

    public function setDay(Day $day) : self
    {
        return new self(
            $day,
            $this->time,
            $this->timeZone
        );
    }

    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        return new \DateTimeImmutable(
            \sprintf(
                '%d-%02d-%02d %02d:%02d:%02d.%06d',
                $this->day->year()->number(),
                $this->day->month()->number(),
                $this->day->number(),
                $this->time->hour(),
                $this->time->minute(),
                $this->time->second(),
                $this->time->microsecond(),
            ),
            $this->timeZone->toDateTimeZone()
        );
    }

    public function toAtomicTime() : self
    {
        return $this->add(LeapSeconds::load()->until($this)->offsetTAI());
    }

    public function toGPSTime() : self
    {
        return $this->add(LeapSeconds::load()
            ->since(TimeEpoch::GPS()->date())
            ->until($this)->count());
    }

    public function format(string $format) : string
    {
        return $this->toDateTimeImmutable()->format($format);
    }

    public function timeZone() : TimeZone
    {
        return $this->timeZone;
    }

    public function timeZoneAbbreviation() : TimeZone
    {
        if ($this->timeZone->isOffset()) {
            throw new Exception("TimeZone offset {$this->timeZone->name()} can't be converted into abbreviation.");
        }

        return TimeZone::fromString($this->toDateTimeImmutable()->format('T'));
    }

    public function toTimeZone(TimeZone $dateTimeZone) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->setTimezone($dateTimeZone->toDateTimeZone()));
    }

    public function toISO8601(bool $extended = true) : string
    {
        return $extended
            ? $this->toDateTimeImmutable()->format('Y-m-d\TH:i:sP')
            : $this->toDateTimeImmutable()->format('Ymd\THisO');
    }

    public function isDaylightSaving() : bool
    {
        return (bool) $this->toDateTimeImmutable()->format('I');
    }

    public function isDaylight() : bool
    {
        return !$this->isDaylightSaving();
    }

    public function timestamp(TimeEpoch $timeEpoch) : TimeUnit
    {
        if ($this->isBefore($timeEpoch->date())) {
            throw new Exception('Given epoch started at ' . $timeEpoch->date()->toISO8601() . ' which was after ' . $this->toISO8601());
        }

        switch ($timeEpoch->type()) {
            case TimeEpoch::UTC:
                return $this->timestampUNIX()
                    ->sub(TimeEpoch::UNIX()->distanceTo($timeEpoch))
                    ->add(LeapSeconds::load()->offsetTAI());
            case TimeEpoch::GPS:
                return $this->timestampUNIX()
                    ->sub(TimeEpoch::UNIX()->distanceTo($timeEpoch))
                    ->add(
                        LeapSeconds::load()->offsetTAI()
                            ->sub(LeapSeconds::load()->until($timeEpoch->date())->offsetTAI())
                    );
            case TimeEpoch::TAI:
                return $timeEpoch->date()->until($this)->distance()
                    ->add($timeEpoch->date()->until($this)->leapSeconds()->offsetTAI());

            default:
                return $this->timestampUNIX();
        }
    }

    /**
     * Number of seconds elapsed since Unix epoch started at 1970-01-01 (1970-01-01T00:00:00Z)
     * Not including leap seconds.
     */
    public function timestampUNIX() : TimeUnit
    {
        $timestamp = $this->toDateTimeImmutable()->getTimestamp();

        if ($timestamp >= 0) {
            return TimeUnit::positive($timestamp, $this->time->microsecond());
        }

        return TimeUnit::negative(\abs($timestamp), $this->time->microsecond());
    }

    public function modify(string $modifier) : self
    {
        $dateTimeParts = \date_parse($modifier);

        if (!\is_array($dateTimeParts)) {
            throw new InvalidArgumentException('Value "{modify}" is not valid relative time format.');
        }

        if ($dateTimeParts['error_count'] > 0) {
            throw new InvalidArgumentException("Value \"{$modifier}\" is not valid relative time format.");
        }

        if (!isset($dateTimeParts['relative']) || !\is_array($dateTimeParts['relative'])) {
            throw new InvalidArgumentException("Value \"{$modifier}\" is not valid relative time format.");
        }

        $dateTime = $this;

        if (
            /** @phpstan-ignore-next-line */
            !\is_int($dateTimeParts['relative']['year']) ||
            !\is_int($dateTimeParts['relative']['month']) ||
            !\is_int($dateTimeParts['relative']['day']) ||
            !\is_int($dateTimeParts['relative']['hour']) ||
            !\is_int($dateTimeParts['relative']['minute']) ||
            !\is_int($dateTimeParts['relative']['second'])
        ) {
            throw new InvalidArgumentException("Value \"{$modifier}\" is not valid relative time format.");
        }

        if ($dateTimeParts['relative']['year'] !== 0) {
            $dateTime = $dateTime->add(RelativeTimeUnit::years($dateTimeParts['relative']['year']));
        }

        if ($dateTimeParts['relative']['month'] !== 0) {
            $dateTime = $dateTime->add(RelativeTimeUnit::months($dateTimeParts['relative']['month']));
        }

        if (\array_key_exists('weekday', $dateTimeParts['relative'])) {
            if ($dateTimeParts['relative']['weekday'] !== 0) {
                $dateTimeWeekDay = $dateTime->day()->weekDay();

                if ($dateTime->day()->weekDay()->number() < (int) $dateTimeParts['relative']['weekday']) {
                    $dateTime = $dateTime->add(TimeUnit::days((int) $dateTimeParts['relative']['weekday'] - $dateTimeWeekDay->number()));
                }
            }
        }

        return $dateTime->add(
            TimeUnit::days($dateTimeParts['relative']['day'])
                ->add(TimeUnit::hours($dateTimeParts['relative']['hour']))
                ->add(TimeUnit::minutes($dateTimeParts['relative']['minute']))
                ->add(TimeUnit::seconds($dateTimeParts['relative']['second']))
        );
    }

    public function addHour() : self
    {
        return $this->add(TimeUnit::hour());
    }

    public function subHour() : self
    {
        return $this->sub(TimeUnit::hour());
    }

    public function addHours(int $hours) : self
    {
        return $this->add(TimeUnit::hours($hours));
    }

    public function subHours(int $hours) : self
    {
        return $this->sub(TimeUnit::hours($hours));
    }

    public function addMinute() : self
    {
        return $this->add(TimeUnit::minute());
    }

    public function subMinute() : self
    {
        return $this->sub(TimeUnit::minute());
    }

    public function addMinutes(int $minutes) : self
    {
        return $this->add(TimeUnit::minutes($minutes));
    }

    public function subMinutes(int $minutes) : self
    {
        return $this->sub(TimeUnit::minutes($minutes));
    }

    public function addSecond() : self
    {
        return $this->add(TimeUnit::second());
    }

    public function subSecond() : self
    {
        return $this->sub(TimeUnit::second());
    }

    public function addSeconds(int $seconds) : self
    {
        return $this->add(TimeUnit::seconds($seconds));
    }

    public function subSeconds(int $seconds) : self
    {
        return $this->sub(TimeUnit::seconds($seconds));
    }

    public function addDay() : self
    {
        return $this->add(TimeUnit::day());
    }

    public function subDay() : self
    {
        return $this->sub(TimeUnit::day());
    }

    public function addDays(int $days) : self
    {
        return $this->add(TimeUnit::days($days));
    }

    public function subDays(int $days) : self
    {
        return $this->sub(TimeUnit::days($days));
    }

    public function addMonth() : self
    {
        return $this->add(RelativeTimeUnit::month());
    }

    public function subMonth() : self
    {
        return $this->sub(RelativeTimeUnit::month());
    }

    public function addMonths(int $months) : self
    {
        return $this->add(RelativeTimeUnit::months($months));
    }

    public function subMonths(int $months) : self
    {
        return $this->sub(RelativeTimeUnit::months($months));
    }

    public function addYear() : self
    {
        return $this->add(RelativeTimeUnit::year());
    }

    public function subYear() : self
    {
        return $this->sub(RelativeTimeUnit::year());
    }

    public function addYears(int $years) : self
    {
        return $this->add(RelativeTimeUnit::years($years));
    }

    public function subYears(int $years) : self
    {
        return $this->sub(RelativeTimeUnit::years($years));
    }

    public function midnight() : self
    {
        return new self(
            $this->day,
            new Time(0, 0, 0, 0),
            $this->timeZone
        );
    }

    public function noon() : self
    {
        return new self(
            $this->day,
            new Time(12, 0, 0, 0),
            $this->timeZone
        );
    }

    public function endOfDay() : self
    {
        return new self(
            $this->day,
            new Time(23, 59, 59, 999999),
            $this->timeZone
        );
    }

    public function yesterday() : self
    {
        return $this->sub(TimeUnit::day())->midnight();
    }

    public function tomorrow() : self
    {
        return $this->add(TimeUnit::day())->midnight();
    }

    /**
     * When adding RelativeTimeUnit::month() this method will try to change month and adjust
     * day of the month.
     * Examples:
     *  - 2021-02-28 + RelativeTimeUnit::month() = 2021-03-28.
     */
    public function add(Unit $timeUnit) : self
    {
        if ($timeUnit instanceof RelativeTimeUnit && $timeUnit->inMonths()) {
            $years = $timeUnit->toPositive()->inYears();
            $months = $timeUnit->inCalendarMonths();

            $newMonth = $timeUnit->isNegative()
                ? $this->month()->sub($years, $months)
                : $this->month()->add($years, $months);

            if ($newMonth->lastDay()->number() < $this->day->number()) {
                return new self(new Day($newMonth, $newMonth->lastDay()->number()), $this->time, $this->timeZone);
            }

            return new self(new Day($newMonth, $this->day->number()), $this->time, $this->timeZone);
        }

        return self::fromDateTime($this->toDateTimeImmutable()->add($timeUnit->toDateInterval()));
    }

    /**
     * When subtracting RelativeTimeUnit::month() this method will try to change month and adjust
     * day of the month.
     * Examples:
     *  - 2021-03-31 - RelativeTimeUnit::month() = 2021-02-28.
     */
    public function sub(Unit $timeUnit) : self
    {
        return $this->add($timeUnit->invert());
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $dateTime) : bool
    {
        return $this->isEqualTo($dateTime);
    }

    public function isEqualTo(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() == $dateTime->toDateTimeImmutable();
    }

    public function isAfter(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() > $dateTime->toDateTimeImmutable();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isAfterOrEqualTo` instead. Will be removed with 2.0
     */
    public function isAfterOrEqual(self $dateTime) : bool
    {
        return $this->isAfterOrEqualTo($dateTime);
    }

    public function isAfterOrEqualTo(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() >= $dateTime->toDateTimeImmutable();
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isBeforeOrEqualTo` instead. Will be removed with 2.0
     */
    public function isBeforeOrEqual(self $dateTime) : bool
    {
        return $this->isBeforeOrEqualTo($dateTime);
    }

    public function isBeforeOrEqualTo(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() <= $dateTime->toDateTimeImmutable();
    }

    public function isBefore(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() < $dateTime->toDateTimeImmutable();
    }

    public function until(self $dateTime) : TimePeriod
    {
        return new TimePeriod($this, $dateTime);
    }

    public function since(self $dateTime) : TimePeriod
    {
        return new TimePeriod($dateTime, $this);
    }

    public function distance(self $dateTime) : TimeUnit
    {
        return $this->until($dateTime)->distance();
    }

    public function distanceSince(self $dateTime) : TimeUnit
    {
        return $this->since($dateTime)->distance();
    }

    public function distanceUntil(self $dateTime) : TimeUnit
    {
        return $this->until($dateTime)->distance();
    }

    public function iterate(self $pointInTime, TimeUnit $by) : TimePeriods
    {
        return $pointInTime->isBefore($this)
            ? $this->since($pointInTime)->iterateBackward($by, Interval::closed())
            : $this->until($pointInTime)->iterate($by, Interval::closed());
    }

    public function isAmbiguous() : bool
    {
        $tz = $this->timeZone;

        if ($tz->timeOffset($this)->isUTC()) {
            return false;
        }

        /**
         * @var array<int, array{ts: int, time: string, offset: int, isdst: bool, abbr: string}> $transitions
         */
        $transitions = $tz->toDateTimeZone()->getTransitions(
            $this->timestampUNIX()->sub(TimeUnit::hours(1)->add(TimeUnit::minute()))->inSeconds(),
            $this->timestampUNIX()->add(TimeUnit::hours(1))->inSeconds(),
        );

        if (\count($transitions) === 1) {
            return false;
        }

        if ($transitions[1]['offset'] - $transitions[0]['offset'] === 3600) {
            return false;
        }

        return true;
    }

    public function quarter() : Quarter
    {
        return $this->year()->quarter((int) \ceil($this->month()->number() / 3));
    }

    public function compareTo(self $dateTime) : int
    {
        if ($this->isEqualTo($dateTime)) {
            return 0;
        }

        return $this->isBefore($dateTime)
            ? -1
            : 1;
    }
}
