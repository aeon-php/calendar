<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Webmozart\Assert\Assert;

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
        Assert::greaterThanEq($hour, 0);
        Assert::lessThanEq($hour, 23);
        Assert::greaterThanEq($minute, 0);
        Assert::lessThanEq($minute, 60);
        Assert::greaterThanEq($second, 0);
        Assert::lessThanEq($second, 60);
        Assert::greaterThanEq($microsecond, 0);
        Assert::lessThan($microsecond, 1000000);

        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
        $this->microsecond = $microsecond;
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
