<?php

declare(strict_types=1);

namespace Aeon\Calendar;

use Aeon\Calculator\PreciseCalculator;
use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\Exception\InvalidArgumentException;

/**
 * @psalm-immutable
 */
final class TimeUnit implements Unit
{
    private const PRECISION_MICROSECOND = 6;

    private const MICROSECONDS_IN_SECOND = 1_000_000;

    private const MICROSECONDS_IN_MILLISECOND = 1_000;

    private const MILLISECONDS_IN_SECOND = 1_000;

    private const SECONDS_IN_MINUTE = 60;

    private const MINUTES_IN_HOUR = 60;

    private const HOURS_IN_DAY = 24;

    private int $seconds;

    private int $microsecond;

    private bool $negative;

    private function __construct(bool $negative, int $seconds, int $microsecond)
    {
        if ($seconds < 0) {
            throw new InvalidArgumentException('Seconds must be greater or equal 0, got ' . $seconds);
        }

        if ($microsecond < 0 || $microsecond >= self::MICROSECONDS_IN_SECOND) {
            throw new InvalidArgumentException('Microsecond must be greater or equal 0 and less than 1000000, got ' . $microsecond);
        }

        $this->negative = $negative;
        $this->seconds = $seconds;
        $this->microsecond = $microsecond;
    }

    /**
     * @psalm-pure
     * Create from number of seconds with 6 decimal point precision.
     * 0.500000 is half of the second, 500000 represents number of microseconds.
     */
    public static function precise(float $seconds) : self
    {
        $secondsString = \number_format(\round($seconds, self::PRECISION_MICROSECOND, PHP_ROUND_HALF_UP), self::PRECISION_MICROSECOND, '.', '');

        $secondsStringParts = \explode('.', $secondsString);

        return new self(
            \floatval($secondsString) < 0,
            \abs(\intval($secondsStringParts[0])),
            \abs(\intval($secondsStringParts[1])),
        );
    }

    /**
     * @psalm-pure
     * @psalm-suppress ImpureMethodCall
     * @psalm-suppress ImpurePropertyFetch
     *
     * Limitations: TimeUnit can't be created from relative DateIntervals like \DateInterval::createFromDateString('4 months')
     * or \DateInterval::createFromDateString('1 years'). It's because years and months are can't be precisely
     * converted into seconds/days/hours.
     */
    public static function fromDateInterval(\DateInterval $dateInterval) : self
    {
        if ($dateInterval->y && !$dateInterval->days) {
            throw new Exception('Can\'t convert ' . $dateInterval->format('P%yY%mM%dDT%hH%iM%sS') . ' precisely to time unit because year can\'t be directly converted to number of seconds.');
        }

        if ($dateInterval->m && !$dateInterval->days) {
            throw new Exception('Can\'t convert ' . $dateInterval->format('P%yY%mM%dDT%hH%iM%sS') . ' precisely to time unit because month can\'t be directly converted to number of seconds.');
        }

        $timeUnit = self::days($dateInterval->days ? \intval($dateInterval->days) : $dateInterval->d)
            ->add(self::hours($dateInterval->h))
            ->add(self::minutes($dateInterval->i))
            ->add(self::seconds($dateInterval->s))
            ->add(self::precise($dateInterval->f));

        return $dateInterval->invert === 1 ? $timeUnit->invert() : $timeUnit;
    }

    public static function fromDateString(string $dateString) : self
    {
        return self::fromDateInterval(\DateInterval::createFromDateString($dateString));
    }

    /** @psalm-pure */
    public static function millisecond() : self
    {
        return new self(false, 0, self::MICROSECONDS_IN_MILLISECOND);
    }

    /** @psalm-pure */
    public static function milliseconds(int $milliseconds) : self
    {
        return new self(
            $milliseconds < 0,
            \abs(\intval($milliseconds / self::MILLISECONDS_IN_SECOND)),
            \abs(($milliseconds * self::MICROSECONDS_IN_MILLISECOND) % self::MICROSECONDS_IN_SECOND)
        );
    }

    /** @psalm-pure */
    public static function day() : self
    {
        return new self(false, self::HOURS_IN_DAY * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    /** @psalm-pure */
    public static function days(int $days) : self
    {
        return new self($days < 0, \abs($days * self::HOURS_IN_DAY * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE), 0);
    }

    /** @psalm-pure */
    public static function hour() : self
    {
        return new self(false, self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE, 0);
    }

    /** @psalm-pure */
    public static function hours(int $hours) : self
    {
        return new self($hours < 0, \abs($hours * self::MINUTES_IN_HOUR * self::SECONDS_IN_MINUTE), 0);
    }

    /** @psalm-pure */
    public static function minute() : self
    {
        return new self(false, self::SECONDS_IN_MINUTE, 0);
    }

    /** @psalm-pure */
    public static function minutes(int $minutes) : self
    {
        return new self($minutes < 0, \abs($minutes * self::SECONDS_IN_MINUTE), 0);
    }

    /** @psalm-pure */
    public static function second() : self
    {
        return new self(false, 1, 0);
    }

    /** @psalm-pure */
    public static function seconds(int $seconds) : self
    {
        return new self($seconds < 0, \abs($seconds), 0);
    }

    /** @psalm-pure */
    public static function negative(int $seconds, int $microsecond) : self
    {
        return new self(true, $seconds, $microsecond);
    }

    /** @psalm-pure */
    public static function positive(int $seconds, int $microsecond) : self
    {
        return new self(false, $seconds, $microsecond);
    }

    /**
     * @return array{seconds: int, microsecond: int, negative: bool}
     */
    public function __serialize() : array
    {
        return [
            'seconds' => $this->seconds,
            'microsecond' => $this->microsecond,
            'negative' => $this->negative,
        ];
    }

    public function toDateInterval() : \DateInterval
    {
        $interval = new \DateInterval(\sprintf('PT%dS', $this->seconds));

        if ($this->negative) {
            /** @psalm-suppress ImpurePropertyAssignment */
            $interval->invert = 1;
        }

        if ($this->microsecond) {
            /** @psalm-suppress ImpurePropertyAssignment */
            $interval->f = $this->microsecond / self::MICROSECONDS_IN_SECOND;
        }

        return $interval;
    }

    public function isZero() : bool
    {
        return $this->seconds === 0 && $this->microsecond === 0;
    }

    public function isNegative() : bool
    {
        return $this->negative;
    }

    public function isPositive() : bool
    {
        return !$this->isNegative();
    }

    public function add(self $timeUnit) : self
    {
        return self::precise((float) (PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->add($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise())));
    }

    public function sub(self $timeUnit) : self
    {
        return self::precise((float) (PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->sub($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise())));
    }

    public function multiply(self $multiplier) : self
    {
        return self::precise((float) (PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->multiply($this->inSecondsPrecise(), $multiplier->inSecondsPrecise())));
    }

    public function divide(self $divider) : self
    {
        return self::precise((float) (PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->divide($this->inSecondsPrecise(), $divider->inSecondsPrecise())));
    }

    public function modulo(self $divider) : self
    {
        return self::precise((float) (PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->modulo($this->inSecondsPrecise(), $divider->inSecondsPrecise())));
    }

    public function isGreaterThan(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isGreaterThan($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    public function isGreaterThanEq(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isGreaterThanEq($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    public function isLessThan(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isLessThan($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    public function isLessThanEq(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isLessThanEq($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    public function isEqual(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isEqual($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    public function inSeconds() : int
    {
        return $this->negative ? -$this->seconds : $this->seconds;
    }

    public function inSecondsPrecise() : string
    {
        return \sprintf(
            '%s%d.%s',
            $this->negative === true ? '-' : '',
            $this->seconds,
            $this->microsecondString()
        );
    }

    public function inSecondsAbs() : int
    {
        return \abs($this->inSeconds());
    }

    public function inTimeSeconds() : int
    {
        return \abs($this->seconds % 60);
    }

    public function inHours() : int
    {
        return $this->negative
            ? -\intval(($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR)
            : \intval(($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR);
    }

    public function inHoursAbs() : int
    {
        return \abs($this->inHours());
    }

    public function inTimeHours() : int
    {
        return \abs($this->inHours() % 24);
    }

    public function inMinutes() : int
    {
        return $this->negative
            ? -\intval($this->seconds / self::SECONDS_IN_MINUTE)
            : \intval($this->seconds / self::SECONDS_IN_MINUTE);
    }

    public function inMinutesAbs() : int
    {
        return \abs($this->inMinutes());
    }

    public function inTimeMinutes() : int
    {
        return \abs($this->inMinutes() % 60);
    }

    public function inDays() : int
    {
        return $this->negative
            ? -\intval((($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR) / self::HOURS_IN_DAY)
            : \intval((($this->seconds / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR) / self::HOURS_IN_DAY);
    }

    public function inDaysAbs() : int
    {
        return \abs($this->inDays());
    }

    /**
     * Number of microseconds from last full second to the next full second.
     * Do not use this method to combine float seconds because for 50000 it returns 50000 not "050000".
     */
    public function microsecond() : int
    {
        return $this->microsecond;
    }

    /**
     * Number of microseconds from last full second to the next full second.
     * Use this method to combine float seconds because for 50000 it returns "050000" not 50000.
     */
    public function microsecondString() : string
    {
        return \str_pad((string) $this->microsecond, self::PRECISION_MICROSECOND, '0', STR_PAD_LEFT);
    }

    public function inMilliseconds() : int
    {
        return $this->isNegative()
            ? -($this->seconds * 1000 + \intval($this->microsecond / self::MICROSECONDS_IN_MILLISECOND))
            : ($this->seconds * 1000 + \intval($this->microsecond / self::MICROSECONDS_IN_MILLISECOND));
    }

    public function inTimeMilliseconds() : int
    {
        return \abs($this->inMilliseconds() % 1000);
    }

    public function inMillisecondsAbs() : int
    {
        return \abs($this->inMilliseconds());
    }

    public function invert() : self
    {
        return new self(!$this->negative, $this->seconds, $this->microsecond);
    }

    public function toNegative() : self
    {
        if ($this->isNegative()) {
            return $this;
        }

        return $this->invert();
    }

    public function toPositive() : self
    {
        if (!$this->isNegative()) {
            return $this;
        }

        return $this->invert();
    }
}
