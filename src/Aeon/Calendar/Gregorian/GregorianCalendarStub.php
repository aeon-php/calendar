<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @codeCoverageIgnore
 */
final class GregorianCalendarStub implements Calendar
{
    private ?\DateTimeImmutable $currentDate;

    public function __construct(?\DateTimeImmutable $currentDate = null)
    {
        $this->currentDate = $currentDate;
    }

    public function timeZone() : TimeZone
    {
        $tz = $this->now()->timeZone();

        return $tz ? $tz : TimeZone::UTC();
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
        return DateTime::fromDateTime(
            $this->currentDate
                ? $this->currentDate
                : new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
        );
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
        $this->currentDate = $dateTime->toDateTimeImmutable();
    }
}
