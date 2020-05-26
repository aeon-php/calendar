<?php

declare(strict_types=1);

namespace Ocelot\Calendar;

use Ocelot\Calendar\Exception\InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class TimeUnit
{
    private const MICROSECONDS_IN_SECOND = 1000000;
    private const MICROSECONDS_IN_MILLISECOND = 1000;
    private const MILLISECONDS_IN_SECOND = 1000;
    private const SECONDS_IN_MINUTE = 60;
    private const MINUTES_IN_HOUR = 60;
    private const HOURS_IN_DAY = 24;

    private int $seconds;
    private int $microsecond;
    private bool $negative;

    private function __construct(bool $negative, int $seconds, int $microseconds)
    {
        Assert::greaterThanEq($seconds, 0);
        Assert::greaterThanEq($microseconds, 0);
        Assert::lessThan($microseconds, self::MICROSECONDS_IN_SECOND);

        $this->negative = $negative;
        $this->seconds = $seconds;
        $this->microsecond = $microseconds;
    }

    /**
     * @psalm-pure
     * Create from number of seconds with 6 decimal point precision.
     * 0.500000 is half of the second, 500000 represents number of microseconds.
     */
    public static function precise(float $seconds) : self
    {
        $secondsString = \number_format($seconds, 6, '.', '');

        $secondsStringParts = \explode('.', $secondsString);

        if (\count($secondsStringParts) !== 2) {
            throw new InvalidArgumentException(\sprintf("Malformed representation of seconds as float, expected number with 6 decimals, got %s", $secondsString));
        }

        return new self(
            $seconds < 0,
            \abs((int) $secondsStringParts[0]),
            \abs((int) $secondsStringParts[1]),
        );
    }

    public static function millisecond() : self
    {
        return new self(false, 0, self::MICROSECONDS_IN_MILLISECOND);
    }

    public static function milliseconds(int $milliseconds) : self
    {
        return new self(
            $milliseconds < 0,
            \abs(\intval($milliseconds / self::MILLISECONDS_IN_SECOND)),
            \abs(($milliseconds * self::MICROSECONDS_IN_MILLISECOND) % self::MICROSECONDS_IN_SECOND)
        );
    }

    public static function day() : self
    {
        return new self(false, self::HOURS_IN_DAY * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    /**
     * @psalm-pure
     */
    public static function days(int $days) : self
    {
        return new self($days < 0, \abs($days * self::HOURS_IN_DAY * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE), 0);
    }

    public static function hour() : self
    {
        return new self(false, self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    /**
     * @psalm-pure
     */
    public static function hours(int $hours) : self
    {
        return new self($hours < 0, \abs($hours * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE), 0);
    }

    public static function minute() : self
    {
        return new self(false, self::SECONDS_IN_MINUTE, 0);
    }

    /**
     * @psalm-pure
     */
    public static function minutes(int $minutes) : self
    {
        return new self($minutes < 0, \abs($minutes * self::SECONDS_IN_MINUTE), 0);
    }

    public static function second() : self
    {
        return new self(false, 1, 0);
    }

    /**
     * @psalm-pure
     */
    public static function seconds(int $seconds) : self
    {
        return new self($seconds < 0, \abs($seconds), 0);
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

    public function add(TimeUnit $timeUnit) : self
    {
        return self::precise($this->inSecondsPrecise() + $timeUnit->inSecondsPrecise());
    }

    public function sub(TimeUnit $timeUnit) : self
    {
        return self::precise($this->inSecondsPrecise() - $timeUnit->inSecondsPrecise());
    }

    public function isGreaterThan(TimeUnit $timeUnit) : bool
    {
        return $this->inSeconds() === $timeUnit->inSeconds()
            ? $this->inSecondsPrecise() > $timeUnit->inSecondsPrecise()
            : $this->inSeconds() > $timeUnit->inSeconds();
    }

    public function isGreaterThanEq(TimeUnit $timeUnit) : bool
    {
        return $this->inSeconds() === $timeUnit->inSeconds()
            ? $this->inSecondsPrecise() >= $timeUnit->inSecondsPrecise()
            : $this->inSeconds() >= $timeUnit->inSeconds();
    }

    public function isLessThan(TimeUnit $timeUnit) : bool
    {
        return $this->inSeconds() === $timeUnit->inSeconds()
            ? $this->inSecondsPrecise() < $timeUnit->inSecondsPrecise()
            : $this->inSeconds() < $timeUnit->inSeconds();
    }

    public function isLessThanEq(TimeUnit $timeUnit) : bool
    {
        return $this->inSeconds() === $timeUnit->inSeconds()
            ? $this->inSecondsPrecise() <= $timeUnit->inSecondsPrecise()
            : $this->inSeconds() <= $timeUnit->inSeconds();
    }

    public function isEqual(TimeUnit $timeUnit) : bool
    {
        return $this->inSeconds() === $timeUnit->inSeconds()
            ? $this->inSecondsPrecise() === $timeUnit->inSecondsPrecise()
            : $this->inSeconds() === $timeUnit->inSeconds();
    }

    public function inSeconds() : int
    {
        return $this->negative ? -$this->seconds : $this->seconds;
    }

    public function inSecondsPrecise() : float
    {
        return (float) \sprintf(
            "%s%d.%s",
            $this->negative ? '-' : '+',
            $this->seconds,
            \str_pad((string) $this->microsecond, 6, "0", STR_PAD_LEFT)
        );
    }

    public function inSecondsPreciseString() : string
    {
        return \number_format(
            (float) \sprintf(
                "%s%d.%s",
                $this->negative ? '-' : '',
                $this->seconds,
                \str_pad((string) $this->microsecond, 6, "0", STR_PAD_LEFT)
            ),
            6,
            '.',
            ''
        );
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

    /**
     * Number of microseconds from last full second to the next full second.
     * To get super precise time unit use Time::inSeconds() Time::microsecond()
     */
    public function microsecond(): int
    {
        return $this->microsecond;
    }

    public function inMilliseconds() : int
    {
        return $this->isNegative()
            ? -($this->seconds * 1000 + \intval($this->microsecond / self::MICROSECONDS_IN_MILLISECOND))
            : ($this->seconds * 1000 + \intval($this->microsecond / self::MICROSECONDS_IN_MILLISECOND));
    }

    public function inMillisecondsAbs() : int
    {
        return \abs($this->inMilliseconds());
    }

    public function invert() : self
    {
        return new self(!$this->negative, $this->seconds, $this->microsecond);
    }
}