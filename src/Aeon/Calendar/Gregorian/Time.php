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
     * @psalm-suppress ImpureMethodCall
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        return new self(
            \intval($dateTime->format('H')),
            \intval($dateTime->format('i')),
            \intval($dateTime->format('s')),
            \intval($dateTime->format('u')),
        );
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $date) : self
    {
        $dateNormalized = \trim(\strtolower($date));
        $timeParts = \date_parse($date);

        if (!\is_array($timeParts)) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid time format.");
        }

        if ($timeParts['error_count'] > 0) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid time format.");
        }

        if (isset($timeParts['relative']) || \in_array($dateNormalized, ['now', 'today'], true)) {
            return self::fromDateTime(new \DateTimeImmutable($date));
        }

        if (!\is_int($timeParts['hour']) || !\is_int($timeParts['minute']) || !\is_int($timeParts['second'])) {
            throw new InvalidArgumentException("Value \"{$date}\" is not valid time format.");
        }

        /** @psalm-suppress MixedArgument */
        $secondsString = \number_format(\round($timeParts['fraction'], self::PRECISION_MICROSECOND, PHP_ROUND_HALF_UP), self::PRECISION_MICROSECOND, '.', '');
        $secondsStringParts = \explode('.', $secondsString);
        $microseconds = \abs(\intval($secondsStringParts[1]));

        return new self($timeParts['hour'], $timeParts['minute'], $timeParts['second'], $microseconds);
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

    public function format(string $format) : string
    {
        return $this->toDateTimeImmutable()->format($format);
    }

    public function toTimeUnit() : TimeUnit
    {
        return TimeUnit::positive($this->second(), $this->microsecond())
            ->add(TimeUnit::minutes($this->minute()))
            ->add(TimeUnit::hours($this->hour()));
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
        return \intval($this->microsecond() / 1000);
    }

    public function isAM() : bool
    {
        return $this->toDateTimeImmutable()->format('a') === 'am';
    }

    public function isPM() : bool
    {
        return $this->toDateTimeImmutable()->format('a') === 'pm';
    }

    public function isGreaterThan(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour(), $time->minute(), $time->second(), $time->microsecond());

        return $dateTimeImmutable > $nextDateTimeImmutable;
    }

    public function isGreaterThanEq(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour(), $time->minute(), $time->second(), $time->microsecond());

        return $dateTimeImmutable >= $nextDateTimeImmutable;
    }

    public function isEqual(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour(), $time->minute(), $time->second(), $time->microsecond());

        return $dateTimeImmutable == $nextDateTimeImmutable;
    }

    public function isLessThan(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour(), $time->minute(), $time->second(), $time->microsecond());

        return $dateTimeImmutable < $nextDateTimeImmutable;
    }

    public function isLessThanEq(self $time) : bool
    {
        $dateTimeImmutable = $this->toDateTimeImmutable();
        $nextDateTimeImmutable = $dateTimeImmutable->setTime($time->hour(), $time->minute(), $time->second(), $time->microsecond());

        return $dateTimeImmutable <= $nextDateTimeImmutable;
    }

    public function add(TimeUnit $timeUnit) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->add($timeUnit->toDateInterval()));
    }

    public function sub(TimeUnit $timeUnit) : self
    {
        return self::fromDateTime($this->toDateTimeImmutable()->sub($timeUnit->toDateInterval()));
    }

    private function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
            ->setTime(
                $this->hour(),
                $this->minute(),
                $this->second(),
                $this->microsecond()
            );
    }
}
