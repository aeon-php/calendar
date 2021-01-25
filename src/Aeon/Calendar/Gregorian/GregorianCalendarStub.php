<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @codeCoverageIgnore
 */
final class GregorianCalendarStub implements Calendar
{
    private TimeZone $timeZone;

    private ?DateTime $currentDate;

    public function __construct(TimeZone $timeZone)
    {
        $this->timeZone = $timeZone;
        $this->currentDate = null;
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
        return Year::fromDateTime($this->now()->toDateTimeImmutable());
    }

    public function currentMonth() : Month
    {
        return Month::fromDateTime($this->now()->toDateTimeImmutable());
    }

    public function currentDay() : Day
    {
        return Day::fromDateTime($this->now()->toDateTimeImmutable());
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
