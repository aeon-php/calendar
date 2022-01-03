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

    /**
     * @var null|\ReflectionClass<Time>
     */
    private static ?\ReflectionClass $reflectionClass = null;

    private ?int $hour = null;

    private ?int $minute = null;

    private ?int $second = null;

    private ?int $microsecond = null;

    private ?\DateTimeImmutable $dateTime = null;

    private bool $clean = true;

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
     * @psalm-suppress ImpureStaticProperty
     * @psalm-suppress PropertyTypeCoercion
     * @psalm-suppress ImpurePropertyAssignment
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress ImpurePropertyAssignment
     */
    public static function fromDateTime(\DateTimeInterface $dateTime) : self
    {
        if (self::$reflectionClass === null) {
            self::$reflectionClass = new \ReflectionClass(self::class);
        }

        $newTime = self::$reflectionClass->newInstanceWithoutConstructor();

        $newTime->dateTime = $dateTime instanceof \DateTime ? \DateTimeImmutable::createFromMutable($dateTime) : $dateTime;
        $newTime->clean = false;

        return $newTime;
    }

    /**
     * @psalm-pure
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
            'hour' => $this->hour(),
            'minute' => $this->minute(),
            'second' => $this->second(),
            'microsecond' => $this->microsecond(),
        ];
    }

    /**
     * @return array{hour: int, minute: int, second: int, microsecond: int}
     */
    public function __serialize() : array
    {
        return [
            'hour' => $this->hour(),
            'minute' => $this->minute(),
            'second' => $this->second(),
            'microsecond' => $this->microsecond(),
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
        return \str_pad((string) $this->hour(), 2, '0', STR_PAD_LEFT) . ':'
            . \str_pad((string) $this->minute(), 2, '0', STR_PAD_LEFT) . ':'
            . \str_pad((string) $this->second(), 2, '0', STR_PAD_LEFT) . '.'
            . \str_pad((string) $this->microsecond(), self::PRECISION_MICROSECOND, '0', STR_PAD_LEFT);
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress PossiblyInvalidPropertyAssignmentValue
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress PossiblyNullArrayAccess
     * @psalm-suppress InvalidNullableReturnType
     */
    public function hour() : int
    {
        if ($this->hour === null) {
            /** @phpstan-ignore-next-line */
            [$hour, $minute, $second, $microsecond] = \sscanf($this->dateTime->format('H-i-s.u'), '%d-%d-%d.%d');

            $this->hour = $hour;
            $this->minute = $minute;
            $this->second = $second;
            $this->microsecond = $microsecond;
        }

        return $this->hour;
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress PossiblyInvalidPropertyAssignmentValue
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress PossiblyNullArrayAccess
     * @psalm-suppress InvalidNullableReturnType
     */
    public function minute() : int
    {
        if ($this->minute === null) {
            /** @phpstan-ignore-next-line */
            [$hour, $minute, $second, $microsecond] = \sscanf($this->dateTime->format('H-i-s.u'), '%d-%d-%d.%d');

            $this->hour = $hour;
            $this->minute = $minute;
            $this->second = $second;
            $this->microsecond = $microsecond;
        }

        return $this->minute;
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress PossiblyInvalidPropertyAssignmentValue
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress PossiblyNullArrayAccess
     * @psalm-suppress InvalidNullableReturnType
     */
    public function second() : int
    {
        if ($this->second === null) {
            /** @phpstan-ignore-next-line */
            [$hour, $minute, $second, $microsecond] = \sscanf($this->dateTime->format('H-i-s.u'), '%d-%d-%d.%d');

            $this->hour = $hour;
            $this->minute = $minute;
            $this->second = $second;
            $this->microsecond = $microsecond;
        }

        return $this->second;
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress PossiblyInvalidPropertyAssignmentValue
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress PossiblyNullArrayAccess
     * @psalm-suppress InvalidNullableReturnType
     */
    public function microsecond() : int
    {
        if ($this->microsecond === null) {
            /** @phpstan-ignore-next-line */
            [$hour, $minute, $second, $microsecond] = \sscanf($this->dateTime->format('H-i-s.u'), '%d-%d-%d.%d');

            $this->hour = $hour;
            $this->minute = $minute;
            $this->second = $second;
            $this->microsecond = $microsecond;
        }

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

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InaccessibleProperty
     * @psalm-suppress InvalidNullableReturnType
     */
    private function toDateTimeImmutable() : \DateTimeImmutable
    {
        if ($this->dateTime === null) {
            $this->dateTime = (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
                ->setTime(
                    $this->hour(),
                    $this->minute(),
                    $this->second(),
                    $this->microsecond()
                );
        }

        if ($this->dateTime !== null && $this->clean === false) {
            $this->dateTime = $this->dateTime
                ->setTime(
                    $this->hour(),
                    $this->minute(),
                    $this->second(),
                    $this->microsecond()
                );
            $this->clean = true;
        }

        return $this->dateTime;
    }
}
