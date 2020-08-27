<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\TimeZone\TimeOffset;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class DateTime
{
    private Day $day;

    private Time $time;

    private ?TimeZone $timeZone;

    private TimeOffset $timeOffset;

    private int $unixTimestamp;

    /**
     * TimeZone is optional, if not provided it will be set to UTC.
     * DateTime always has TimeOffset but when not provided it's calculated from offset and when
     * offset is not provided is set to UTC.
     */
    public function __construct(Day $day, Time $time, ?TimeZone $timeZone = null, ?TimeOffset $timeOffset = null)
    {
        if ($timeZone !== null && $timeOffset !== null) {
            if ($timeZone->toDateTimeZone()->getOffset(
                $day->toDateTimeImmutable()
                        ->setTimeZone($timeZone->toDateTimeZone())
                        ->setTime($time->hour(), $time->minute(), $time->second())
            ) !== $timeOffset->toTimeUnit()->inSeconds()) {
                throw new InvalidArgumentException(\sprintf(
                    'TimeOffset %s does not match TimeZone %s at %s',
                    $timeOffset->toString(),
                    $timeZone->name(),
                    $day->toDateTimeImmutable()->setTimeZone($timeZone->toDateTimeZone())->setTime($time->hour(), $time->minute(), $time->second())->format('Y-m-d H:i:s')
                ));
            }
        }

        $this->day = $day;
        $this->time = $time;
        $this->timeZone = $timeZone !== null
            ? $timeZone
            : (($timeOffset !== null && $timeOffset->isUTC()) ? TimeZone::UTC() : null);

        $this->timeOffset = $timeOffset !== null
            ? $timeOffset
            : (
                $timeZone !== null
                ? ($timeZone->name() === 'UTC' ? TimeOffset::UTC() : $timeZone->timeOffset($this))
                : TimeOffset::UTC()
            );

        $dateTimeImmutable = $this->toDateTimeImmutable();

        $this->unixTimestamp = $dateTimeImmutable->getTimestamp();

        if ($this->time->toString() !== $dateTimeImmutable->format('H:i:s.u')) {
            $this->time = Time::fromDateTime($this->toDateTimeImmutable());
        }
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
            new TimeZone($timezone)
        );
    }

    /**
     * @psalm-pure
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        try {
            $tz = TimeZone::fromDateTimeZone($dateTime->getTimezone());
        } catch (InvalidArgumentException $e) {
            $tz = null;
        }

        return new self(
            Day::fromDateTime($dateTime),
            Time::fromDateTime($dateTime),
            $tz,
            TimeOffset::fromTimeUnit(TimeUnit::seconds($dateTime->getOffset()))
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
     * @psalm-pure
     */
    public static function fromTimestampUnix(int $timestamp) : self
    {
        return self::fromDateTime((new \DateTimeImmutable)->setTimestamp($timestamp));
    }

    public function __toString() : string
    {
        return $this->toISO8601();
    }

    public function year() : Year
    {
        return $this->month()->year();
    }

    public function month() : Month
    {
        return $this->day()->month();
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
            $this->day(),
            $time,
            $this->timeZone(),
            $this->timeOffset()
        );
    }

    public function setTimeIn(Time $time, TimeZone $timeZone) : self
    {
        return (new self(
            $this->day(),
            $time,
            $this->timeZone(),
            $this->timeOffset()
        ))->toTimeZone($timeZone)
            ->setTime($time);
    }

    public function setDay(Day $day) : self
    {
        return new self(
            $day,
            $this->time(),
            $this->timeZone(),
            $this->timeOffset()
        );
    }

    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        $tz = $this->timeZone();

        return new \DateTimeImmutable(
            \sprintf(
                '%d-%d-%d %d:%d:%d.%06d',
                $this->day->year()->number(),
                $this->day->month()->number(),
                $this->day->number(),
                $this->time->hour(),
                $this->time->minute(),
                $this->time->second(),
                $this->time->microsecond()
            ),
            $tz !== null
                ? $tz->toDateTimeZone()
                : $this->timeOffset()->toDateTimeZone()
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

    public function timeZone() : ?TimeZone
    {
        return $this->timeZone;
    }

    public function timeOffset() : TimeOffset
    {
        return $this->timeOffset;
    }

    /**
     * @psalm-pure
     */
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
        $unixTimestamp = $this->unixTimestamp;

        return $unixTimestamp >= 0
            ? TimeUnit::positive($unixTimestamp, $this->time->microsecond())
            : TimeUnit::negative(\abs($unixTimestamp), $this->time->microsecond());
    }

    public function modify(string $modify) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->modify($modify));
    }

    public function addHour() : self
    {
        return $this->modify('+1 hour');
    }

    public function subHour() : self
    {
        return $this->modify('-1 hour');
    }

    public function addHours(int $hours) : self
    {
        return $this->modify(\sprintf('+%d hour', $hours));
    }

    public function subHours(int $hours) : self
    {
        return $this->modify(\sprintf('-%d hour', $hours));
    }

    public function addMinute() : self
    {
        return $this->modify('+1 minute');
    }

    public function subMinute() : self
    {
        return $this->modify('-1 minute');
    }

    public function addMinutes(int $minutes) : self
    {
        return $this->modify(\sprintf('+%d minute', $minutes));
    }

    public function subMinutes(int $minutes) : self
    {
        return $this->modify(\sprintf('-%d minute', $minutes));
    }

    public function addSecond() : self
    {
        return $this->modify('+1 second');
    }

    public function subSecond() : self
    {
        return $this->modify('-1 second');
    }

    public function addSeconds(int $seconds) : self
    {
        return $this->modify(\sprintf('+%d second', $seconds));
    }

    public function subSeconds(int $seconds) : self
    {
        return $this->modify(\sprintf('-%d second', $seconds));
    }

    public function addDay() : self
    {
        return $this->modify('+1 day');
    }

    public function subDay() : self
    {
        return $this->modify('-1 day');
    }

    public function addDays(int $days) : self
    {
        return $this->modify(\sprintf('+%d day', $days));
    }

    public function subDays(int $days) : self
    {
        return $this->modify(\sprintf('-%d day', $days));
    }

    public function addMonth() : self
    {
        return $this->modify('+1 month');
    }

    public function subMonth() : self
    {
        return $this->modify('-1 month');
    }

    public function addMonths(int $months) : self
    {
        return $this->modify(\sprintf('+%d months', $months));
    }

    public function subMonths(int $months) : self
    {
        return $this->modify(\sprintf('-%d months', $months));
    }

    public function addYear() : self
    {
        return $this->modify('+1 year');
    }

    public function subYear() : self
    {
        return $this->modify('-1 year');
    }

    public function addYears(int $years) : self
    {
        return $this->modify(\sprintf('+%d years', $years));
    }

    public function subYears(int $years) : self
    {
        return $this->modify(\sprintf('-%d years', $years));
    }

    public function midnight() : self
    {
        return new self(
            $this->day(),
            new Time(0, 0, 0, 0),
            $this->timeZone(),
            $this->timeOffset()
        );
    }

    public function noon() : self
    {
        return new self(
            $this->day(),
            new Time(12, 0, 0, 0),
            $this->timeZone(),
            $this->timeOffset()
        );
    }

    public function endOfDay() : self
    {
        return new self(
            $this->day(),
            new Time(23, 59, 59, 999999),
            $this->timeZone(),
            $this->timeOffset()
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

    public function add(TimeUnit $timeUnit) : self
    {
        return $this->modify(\sprintf(
            '%s%d seconds %s microsecond',
            $timeUnit->isPositive() ? '+' : '-',
            $timeUnit->inSeconds(),
            $timeUnit->microsecondString()
        ));
    }

    public function sub(TimeUnit $timeUnit) : self
    {
        return $this->modify(\sprintf(
            '%s%d seconds %d microsecond',
            $timeUnit->isPositive() ? '-' : '+',
            $timeUnit->inSeconds(),
            $timeUnit->microsecondString()
        ));
    }

    public function isEqual(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() == $dateTime->toDateTimeImmutable();
    }

    public function isAfter(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() > $dateTime->toDateTimeImmutable();
    }

    public function isAfterOrEqual(self $dateTime) : bool
    {
        return $this->toDateTimeImmutable() >= $dateTime->toDateTimeImmutable();
    }

    public function isBeforeOrEqual(self $dateTime) : bool
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
        $tz = $this->timeZone();

        if ($tz === null || $tz->timeOffset($this)->isUTC()) {
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
}
