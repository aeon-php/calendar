<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Gregorian\TimeZone\TimeOffset;
use Aeon\Calendar\TimeUnit;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class DateTime
{
    private Day $day;

    private Time $time;

    private ?TimeZone $timeZone;

    private TimeOffset $timeOffset;

    /**
     * TimeZone is optional, if not provided it will be set to UTC.
     * DateTime always has TimeOffset but when not provided it's calculated from offset and when
     * offset is not provided is set to UTC.
     */
    public function __construct(Day $day, Time $time, ?TimeZone $timeZone = null, ?TimeOffset $timeOffset = null)
    {
        if ($timeZone !== null && $timeOffset !== null) {
            Assert::same(
                $timeZone->toDateTimeZone()->getOffset($day->toDateTimeImmutable()->setTime($time->hour(), $time->minute(), $time->second())),
                $timeOffset->toTimeUnit()->inSeconds(),
                \sprintf(
                    "TimeOffset %s does not match TimeZone %s at %s",
                    $timeOffset->toString(),
                    $timeZone->name(),
                    $day->toDateTimeImmutable()->setTime($time->hour(), $time->minute(), $time->second())->format('Y-m-d H:i:s')
                )
            );
        }

        $this->day = $day;
        $this->time = $time;
        $this->timeZone = $timeZone !== null
            ? $timeZone
            : (($timeOffset !== null && $timeOffset->isUTC()) ? TimeZone::UTC() : null);

        $this->timeOffset = $timeOffset !== null
            ? $timeOffset
            : ($timeZone !== null ? $timeZone->timeOffset($this) : TimeOffset::UTC());
    }

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
        return new self(
            Day::fromDateTime($dateTime),
            Time::fromDateTime($dateTime),
            TimeZone::isValid($dateTime->getTimezone()->getName())
                ? TimeZone::fromDateTimeZone($dateTime->getTimezone())
                : null,
            TimeOffset::fromString($dateTime->format('P'))
        );
    }

    public static function fromString(string $date) : self
    {
        return self::fromDateTime(new \DateTimeImmutable($date));
    }

    public static function fromTimestamp(int $timestamp) : self
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

    public function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (
            new \DateTimeImmutable(
                $this->day->toDateTimeImmutable()->format('Y-m-d'),
                $this->timeZone() !== null
                    ? $this->timeZone()->toDateTimeZone()
                    : $this->timeOffset()->toDateTimeZone()
            ))
            ->setTime(
                $this->time->hour(),
                $this->time->minute(),
                $this->time->second(),
                $this->time->microsecond()
            );
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

    public function toTimeZone(TimeZone $dateTimeZone) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->setTimezone($dateTimeZone->toDateTimeZone()));
    }

    public function toISO8601() : string
    {
        return $this->toDateTimeImmutable()->format(\DateTimeInterface::ISO8601);
    }

    public function isDaylight() : bool
    {
        return (bool) $this->toDateTimeImmutable()->format('I');
    }

    public function isSavingTime() : bool
    {
        return !$this->isDaylight();
    }

    public function secondsSinceUnixEpoch() : int
    {
        return (int) $this->toDateTimeImmutable()->format('U');
    }

    public function secondsSinceUnixEpochPrecise() : float
    {
        return (float) \sprintf("%d.%s", $this->secondsSinceUnixEpoch(), \str_pad((string) $this->time()->microsecond(), 6, "0", STR_PAD_LEFT));
    }

    public function timestamp() : int
    {
        return $this->secondsSinceUnixEpoch();
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
        return $this->day()->midnight();
    }

    public function noon() : self
    {
        return $this->day()->noon();
    }

    public function endOfDay() : self
    {
        return $this->day()->endOfDay();
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

    public function isEqual(DateTime $dateTime) : bool
    {
        return $this->toDateTimeImmutable() == $dateTime->toDateTimeImmutable();
    }

    public function isAfter(DateTime $dateTime) : bool
    {
        return $this->toDateTimeImmutable() > $dateTime->toDateTimeImmutable();
    }

    public function isAfterOrEqual(DateTime $dateTime) : bool
    {
        return $this->toDateTimeImmutable() >= $dateTime->toDateTimeImmutable();
    }

    public function isBeforeOrEqual(DateTime $dateTime) : bool
    {
        return $this->toDateTimeImmutable() <= $dateTime->toDateTimeImmutable();
    }

    public function isBefore(DateTime $dateTime) : bool
    {
        return $this->toDateTimeImmutable() < $dateTime->toDateTimeImmutable();
    }

    public function to(DateTime $dateTime) : TimePeriod
    {
        return new TimePeriod($this, $dateTime);
    }

    public function from(DateTime $dateTime) : TimePeriod
    {
        return new TimePeriod($dateTime, $this);
    }

    public function distanceTo(DateTime $dateTime) : TimeUnit
    {
        return $this->to($dateTime)->distance();
    }

    public function distanceFrom(DateTime $dateTime) : TimeUnit
    {
        return $this->from($dateTime)->distance();
    }

    public function until(DateTime $pointInTime, TimeUnit $by) : TimePeriods
    {
        return $pointInTime->isBefore($this)
            ? $this->from($pointInTime)->iterateBackward($by)
            : $this->to($pointInTime)->iterate($by);
    }
}
