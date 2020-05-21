<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class TimeUnit
{
    private const MICROSECONDS_IN_SECOND = 1000000;
    private const SECONDS_IN_MINUTE = 60;
    private const MINUTES_IN_HOUR = 60;
    private const HOURS_IN_DAY = 24;

    private int $seconds;
    private int $microseconds;
    private bool $negative;

    private function __construct(int $seconds, int $microseconds)
    {
        Assert::greaterThanEq($microseconds, 0);
        Assert::lessThan($microseconds, self::MICROSECONDS_IN_SECOND);

        $this->seconds = abs($seconds);
        $this->microseconds = $microseconds;
        $this->negative = $seconds < 0;
    }

    /**
     * @psalm-suppress ImpurePropertyAssignment
     */
    public function toDateInterval() : \DateInterval
    {
        $interval = new \DateInterval(\sprintf("PT%dS", $this->seconds));

        if ($this->negative) {
            $interval->invert = 1;
        }

        return $interval;
    }

    public function isNegative() : bool
    {
        return $this->negative;
    }

    public function isPositive() : bool
    {
        return !$this->isNegative();
    }

    public static function day() : self
    {
        return new self(self::HOURS_IN_DAY * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    public static function days(int $days) : self
    {
        return new self($days * self::HOURS_IN_DAY * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    public static function hour() : self
    {
        return new self(self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    public static function hours(int $hours) : self
    {
        return new self($hours * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    public static function minute() : self
    {
        return new self(self::SECONDS_IN_MINUTE, 0);
    }

    public static function minutes(int $minutes) : self
    {
        return new self($minutes * self::SECONDS_IN_MINUTE, 0);
    }

    public static function second() : self
    {
        return new self(1, 0);
    }

    public function add(TimeUnit $timeUnit) : self
    {
        return new self($timeUnit->inSeconds() + $this->inSeconds(), 0);
    }

    public function sub(TimeUnit $timeUnit) : self
    {
        return new self($this->inSeconds() - $timeUnit->inSeconds(), 0);
    }

    public function isGreaterThan(TimeUnit $timeUnit) : bool
    {
        return $timeUnit->inSeconds() > $timeUnit->inSeconds();
    }

    public function isGreaterThanEq(TimeUnit $timeUnit) : bool
    {
        return $timeUnit->inSeconds() >= $timeUnit->inSeconds();
    }

    public function isLessThan(TimeUnit $timeUnit) : bool
    {
        return $timeUnit->inSeconds() < $timeUnit->inSeconds();
    }

    public function isLessThanEq(TimeUnit $timeUnit) : bool
    {
        return $timeUnit->inSeconds() <= $timeUnit->inSeconds();
    }

    public function isEqual(TimeUnit $timeUnit) : bool
    {
        return $timeUnit->inSeconds() === $timeUnit->inSeconds();
    }

    /**
     * @psalm-pure
     */
    public static function seconds(int $seconds) : self
    {
        return new self($seconds, 0);
    }

    public function inSeconds() : int
    {
        return $this->negative ? -$this->seconds : $this->seconds;
    }

    public function inSecondsAbs() : int
    {
        return \abs($this->inSeconds());
    }

    public function inTimeSeconds() : int
    {
        return $this->seconds % 60;
    }

    public function inHours() : int
    {
        return $this->negative
            ? -(int) (($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR)
            : (int) (($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR);
    }

    public function inHoursAbs() : int
    {
        return \abs($this->inHours());
    }

    public function inMinutes() : int
    {
        return $this->negative
            ? - (int) ($this->seconds / self::SECONDS_IN_MINUTE)
            : (int) ($this->seconds / self::SECONDS_IN_MINUTE);
    }

    public function inMinutesAbs() : int
    {
        return \abs($this->inMinutes());
    }

    public function inTimeMinutes() : int
    {
        return $this->inMinutes() % 60;
    }

    public function inDays() : int
    {
        return $this->negative
            ? -(int) ((($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR) / self::HOURS_IN_DAY)
            : (int) ((($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR) / self::HOURS_IN_DAY);
    }

    public function inDaysAbs() : int
    {
        return \abs($this->inDays());
    }

    public function invert() : self
    {
        return new self(-1 * \abs($this->seconds), $this->microseconds);
    }
}