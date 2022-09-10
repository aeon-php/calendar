<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class Time
{
    private const PRECISION_MICROSECOND = 6;

    private int $hour;

    private int $minute;

    private int $second;

    private int $microsecond;

    public function __construct(int $hour, int $minute, int $second, int $microsecond = 0)
    {
        if ($hour < 0 || $hour > 23) {
            throw new InvalidArgumentException('Hour must be greater or equal 0 and less or equal than 23');
        }

        if ($minute < 0 || $minute >= 60) {
            throw new InvalidArgumentException('Minut must be greater or equal 0 and less than 60');
        }

        if ($second < 0 || $second >= 60) {
            throw new InvalidArgumentException('Second must be greater or equal 0 and less than 60');
        }

        if ($microsecond < 0 || $microsecond >= 1000000) {
            throw new InvalidArgumentException('Microsecond must be greater or equal 0 and less than 1000000');
        }

        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
        $this->microsecond = $microsecond;
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall
     * @psalm-suppress PossiblyNullArrayAccess
     * @psalm-suppress PossiblyInvalidArgument
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        /**
         * @phpstan-ignore-next-line
         */
        [$hour, $minute, $second, $microsecond] = \sscanf($dateTime->format('H-i-s.u'), '%d-%d-%d.%d');

        /** @phpstan-ignore-next-line */
        return new self($hour, $minute, $second, $microsecond);
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromString(string $time) : self
    {
        try {
            return self::fromDateTime(new \DateTimeImmutable($time));
        } catch (\Exception $e) {
            throw new InvalidArgumentException("Value \"{$time}\" is not valid time format.");
        }
    }

    /**
     * @return array{hour: int, minute: int, second: int, microsecond: int}
     */
    public function __debugInfo() : array
    {
        return [
            'hour' => $this->hour,
            'minute' => $this->minute,
            'second' => $this->second,
            'microsecond' => $this->microsecond,
        ];
    }

    /**
     * @return array{hour: int, minute: int, second: int, microsecond: int}
     */
    public function __serialize() : array
    {
        return [
            'hour' => $this->hour,
            'minute' => $this->minute,
            'second' => $this->second,
            'microsecond' => $this->microsecond,
        ];
    }

    /**
     * @param array{hour: int, minute: int, second: int, microsecond: int} $data
     */
    public function __unserialize(array $data) : void
    {
        $this->hour = $data['hour'];
        $this->minute = $data['minute'];
        $this->second = $data['second'];
        $this->microsecond = $data['microsecond'];
    }

    public function format(string $format) : string
    {
        return $this->toDateTimeImmutable()->format($format);
    }

    public function toTimeUnit() : TimeUnit
    {
        return TimeUnit::positive($this->second, $this->microsecond)
            ->add(TimeUnit::minutes($this->minute))
            ->add(TimeUnit::hours($this->hour));
    }

    public function toString() : string
    {
        return \str_pad((string) $this->hour, 2, '0', STR_PAD_LEFT) . ':'
            . \str_pad((string) $this->minute, 2, '0', STR_PAD_LEFT) . ':'
            . \str_pad((string) $this->second, 2, '0', STR_PAD_LEFT) . '.'
            . \str_pad((string) $this->microsecond, self::PRECISION_MICROSECOND, '0', STR_PAD_LEFT);
    }

    public function hour() : int
    {
        return $this->hour;
    }

    public function minute() : int
    {
        return $this->minute;
    }

    public function second() : int
    {
        return $this->second;
    }

    public function microsecond() : int
    {
        return $this->microsecond;
    }

    public function millisecond() : int
    {
        return \intval($this->microsecond / 1000);
    }

    public function isAM() : bool
    {
        return $this->toDateTimeImmutable()->format('a') === 'am';
    }

    public function isPM() : bool
    {
        return $this->toDateTimeImmutable()->format('a') === 'pm';
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isAfter` instead. Will be removed with 2.0
     */
    public function isGreaterThan(self $time) : bool
    {
        return $this->isAfter($time);
    }

    public function isAfter(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour, $time->minute, $time->second, $time->microsecond);

        return $dateTimeImmutable > $nextDateTimeImmutable;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isAfterOrEqualTo` instead. Will be removed with 2.0
     */
    public function isGreaterThanEq(self $time) : bool
    {
        return $this->isAfterOrEqualTo($time);
    }

    public function isAfterOrEqualTo(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour, $time->minute, $time->second, $time->microsecond);

        return $dateTimeImmutable >= $nextDateTimeImmutable;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $time) : bool
    {
        return $this->isEqualTo($time);
    }

    public function isEqualTo(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour, $time->minute, $time->second, $time->microsecond);

        return $dateTimeImmutable == $nextDateTimeImmutable;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isBefore` instead. Will be removed with 2.0
     */
    public function isLessThan(self $time) : bool
    {
        return $this->isBefore($time);
    }

    public function isBefore(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour, $time->minute, $time->second, $time->microsecond);

        return $dateTimeImmutable < $nextDateTimeImmutable;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isBeforeOrEqualTo` instead. Will be removed with 2.0
     */
    public function isLessThanEq(self $time) : bool
    {
        return $this->isBeforeOrEqualTo($time);
    }

    public function isBeforeOrEqualTo(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour, $time->minute, $time->second, $time->microsecond);

        return $dateTimeImmutable <= $nextDateTimeImmutable;
    }

    public function isMidnight() : bool
    {
        return $this->hour() === 0
            && $this->minute() === 0
            && $this->second() === 0
            && $this->microsecond() === 0;
    }

    public function isNotMidnight() : bool
    {
        return !$this->isMidnight();
    }

    public function add(TimeUnit $timeUnit) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->add($timeUnit->toDateInterval()));
    }

    public function sub(TimeUnit $timeUnit) : self
    {
        /** @psalm-suppress PossiblyFalseArgument */
        return self::fromDateTime($this->toDateTimeImmutable()->sub($timeUnit->toDateInterval()));
    }

    public function compareTo(self $time) : int
    {
        if ($this->isEqualTo($time)) {
            return 0;
        }

        return $this->isBefore($time)
            ? -1
            : 1;
    }

    private function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
            ->setTime(
                $this->hour,
                $this->minute,
                $this->second,
                $this->microsecond
            );
    }
}
