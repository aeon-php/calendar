<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 *
 * @codeCoverageIgnore
 */
final class GregorianCalendarStub implements Calendar
{
    private TimeZone $timeZone;

    private ?DateTime $currentDate;

    public function __construct(TimeZone $timeZone, ?DateTime $currentDate = null)
    {
        $this->timeZone = $timeZone;
        $this->currentDate = $currentDate;
    }

    /**
     * @psalm-pure
     */
    public static function UTC(?DateTime $currentDate = null) : self
    {
        return new self(TimeZone::UTC(), $currentDate);
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureFunctionCall
     */
    public static function systemDefault(?DateTime $currentDate = null) : self
    {
        return new self(TimeZone::fromString(\date_default_timezone_get()), $currentDate);
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
        return $this->currentDate
            ? $this->currentDate
            : DateTime::fromDateTime(new \DateTimeImmutable('now', $this->timeZone->toDateTimeZone()));
    }

    public function yesterday() : DateTime
    {
        return $this->now()->yesterday();
    }

    public function tomorrow() : DateTime
    {
        return $this->now()->tomorrow();
    }

    /**
     * @psalm-suppress InaccessibleProperty
     */
    public function setNow(DateTime $dateTime) : void
    {
        $this->currentDate = $dateTime;
    }
}
