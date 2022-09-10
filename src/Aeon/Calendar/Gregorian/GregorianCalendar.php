<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class GregorianCalendar implements Calendar
{
    private TimeZone $timeZone;

    public function __construct(TimeZone $timeZone)
    {
        $this->timeZone = $timeZone;
    }

    /**
     * @psalm-pure
     */
    public static function UTC() : self
    {
        return new self(TimeZone::UTC());
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureFunctionCall
     */
    public static function systemDefault() : self
    {
        return new self(TimeZone::fromString(\date_default_timezone_get()));
    }

    public function timeZone() : TimeZone
    {
        return $this->timeZone;
    }

    public function currentYear() : Year
    {
        return $this->now()->year();
    }

    public function currentMonth() : Month
    {
        return $this->now()->month();
    }

    public function currentDay() : Day
    {
        return $this->now()->day();
    }

    public function now() : DateTime
    {
        if ($this->timeZone->name() === 'UTC') {
            return DateTime::fromDateTime(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        }

        return DateTime::fromDateTime(new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
            ->toTimeZone($this->timeZone);
    }

    public function yesterday() : DateTime
    {
        return $this->now()->yesterday();
    }

    public function tomorrow() : DateTime
    {
        return $this->now()->tomorrow();
    }
}
