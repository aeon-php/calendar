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
            (int) $dateTime->format('H'),
            (int) $dateTime->format('i'),
            (int) $dateTime->format('s'),
            (int) $dateTime->format('u'),
        );
    }

    public static function fromString(string $date) : self
    {
        return self::fromDateTime(new \DateTimeImmutable($date));
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
            . \str_pad((string) $this->microsecond, 6, '0', STR_PAD_LEFT);
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
        return (int) ($this->microsecond() / 1000);
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
