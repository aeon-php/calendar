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

    /**
     * @var null|\ReflectionClass<TimeUnit>
     */
    private static ?\ReflectionClass $reflectionClass = null;

    private ?int $seconds = null;

    private ?int $microsecond = null;

    private ?\DateInterval $dateInterval = null;

    private bool $negative = false;

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
        $this->dateInterval = null;
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
     *
     * @psalm-suppress ImpureMethodCall
     * @psalm-suppress ImpurePropertyFetch
     * @psalm-suppress ImpureStaticProperty
     * @psalm-suppress ImpurePropertyAssignment
     * @psalm-suppress InaccessibleProperty
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

        if (self::$reflectionClass === null) {
            self::$reflectionClass = new \ReflectionClass(self::class);
        }

        $newTimeUnit = self::$reflectionClass->newInstanceWithoutConstructor();

        $newTimeUnit->dateInterval = $dateInterval;

        return $newTimeUnit;
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
            'seconds' => $this->getSeconds(),
            'microsecond' => $this->microsecond(),
            'negative' => $this->isNegative(),
        ];
    }

    /**
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InvalidNullableReturnType
     */
    public function toDateInterval() : \DateInterval
    {
        if ($this->dateInterval === null) {
            $interval = new \DateInterval(\sprintf('PT%dS', $this->getSeconds()));

            if ($this->negative) {
                /** @psalm-suppress ImpurePropertyAssignment */
                $interval->invert = 1;
            }

            if ($this->microsecond) {
                /** @psalm-suppress ImpurePropertyAssignment */
                $interval->f = $this->microsecond / self::MICROSECONDS_IN_SECOND;
            }

            $this->dateInterval = $interval;
        }

        return $this->dateInterval;
    }

    public function isZero() : bool
    {
        return $this->getSeconds() === 0 && $this->microsecond() === 0;
    }

    public function isNegative() : bool
    {
        /** @psalm-suppress UnusedMethodCall */
        $this->getSeconds();

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

    /** @deprecated Use `isGreaterThanOrEqualTo` instead. Will be removed with 2.0 */
    public function isGreaterThanEq(self $timeUnit) : bool
    {
        return $this->isGreaterThanOrEqualTo($timeUnit);
    }

    public function isGreaterThanOrEqualTo(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isGreaterThanOrEqualTo($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    public function isLessThan(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isLessThan($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    /** @deprecated Use `isLessThanOrEqualTo` instead. Will be removed with 2.0 */
    public function isLessThanEq(self $timeUnit) : bool
    {
        return $this->isLessThanOrEqualTo($timeUnit);
    }

    public function isLessThanOrEqualTo(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isLessThanOrEqualTo($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $timeUnit) : bool
    {
        return $this->isEqualTo($timeUnit);
    }

    public function isEqualTo(self $timeUnit) : bool
    {
        return PreciseCalculator::initialize(self::PRECISION_MICROSECOND)->isEqualTo($this->inSecondsPrecise(), $timeUnit->inSecondsPrecise());
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     */
    public function inSeconds() : int
    {
        return $this->isNegative() ? -$this->getSeconds() : $this->getSeconds();
    }

    public function inSecondsPrecise() : string
    {
        return \sprintf(
            '%s%d.%s',
            $this->isNegative() === true ? '-' : '',
            $this->getSeconds(),
            $this->microsecondString()
        );
    }

    public function inSecondsAbs() : int
    {
        return \abs($this->getSeconds());
    }

    public function inTimeSeconds() : int
    {
        return \abs($this->getSeconds() % 60);
    }

    public function inHours() : int
    {
        return $this->isNegative()
            ? -\intval(($this->getSeconds() / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR)
            : \intval(($this->getSeconds() / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR);
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
            ? -\intval($this->getSeconds() / self::SECONDS_IN_MINUTE)
            : \intval($this->getSeconds() / self::SECONDS_IN_MINUTE);
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
        return $this->isNegative()
            ? -\intval((($this->getSeconds() / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR) / self::HOURS_IN_DAY)
            : \intval((($this->getSeconds() / self::SECONDS_IN_MINUTE) / self::MINUTES_IN_HOUR) / self::HOURS_IN_DAY);
    }

    public function inDaysAbs() : int
    {
        return \abs($this->inDays());
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InvalidNullableReturnType
     *
     * Number of microseconds from last full second to the next full second.
     * Do not use this method to combine float seconds because for 50000 it returns 50000 not "050000".
     */
    public function microsecond() : int
    {
        /** @psalm-suppress UnusedMethodCall */
        $this->getSeconds();

        /** @phpstan-ignore-next-line  */
        return $this->microsecond;
    }

    /**
     * Number of microseconds from last full second to the next full second.
     * Use this method to combine float seconds because for 50000 it returns "050000" not 50000.
     */
    public function microsecondString() : string
    {
        return \str_pad((string) $this->microsecond(), self::PRECISION_MICROSECOND, '0', STR_PAD_LEFT);
    }

    public function inMilliseconds() : int
    {
        return $this->isNegative()
            ? -($this->getSeconds() * 1000 + \intval($this->microsecond() / self::MICROSECONDS_IN_MILLISECOND))
            : ($this->getSeconds() * 1000 + \intval($this->microsecond() / self::MICROSECONDS_IN_MILLISECOND));
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
        return new self(!$this->isNegative(), $this->getSeconds(), $this->microsecond());
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

    /**
     * @psalm-suppress PossiblyNullArgument
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InvalidNullableReturnType
     */
    private function getSeconds() : int
    {
        if ($this->seconds === null) {
            /** @phpstan-ignore-next-line */
            $timeUnit = self::days($this->dateInterval->days ? \intval($this->dateInterval->days) : $this->dateInterval->d)
                /** @phpstan-ignore-next-line  */
                ->add(self::hours($this->dateInterval->h))
                /** @phpstan-ignore-next-line  */
                ->add(self::minutes($this->dateInterval->i))
                /** @phpstan-ignore-next-line  */
                ->add(self::seconds($this->dateInterval->s))
                /** @phpstan-ignore-next-line  */
                ->add(self::precise($this->dateInterval->f));

            /** @phpstan-ignore-next-line  */
            $timeUnit = $this->dateInterval->invert === 1 ? $timeUnit->invert() : $timeUnit;

            $this->negative = $timeUnit->isNegative();
            $this->seconds = $timeUnit->getSeconds();
            $this->microsecond = $timeUnit->microsecond();
        }

        return $this->seconds;
    }
}
