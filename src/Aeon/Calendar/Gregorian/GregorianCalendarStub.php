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

    public function year() : Year
    {
        return Year::fromDateTime($this->now()->toDateTimeImmutable());
    }

    public function month() : Month
    {
        return Month::fromDateTime($this->now()->toDateTimeImmutable());
    }

    public function day() : Day
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
        return new DateTime($this->day()->previous(), new Time(0, 0, 0, 0));
    }

    public function tomorrow() : DateTime
    {
        return new DateTime($this->day()->next(), new Time(0, 0, 0, 0));
    }

    /**
     * @psalm-suppress InaccessibleProperty
     */
    public function setNow(DateTime $dateTime) : void
    {
        $this->currentDate = $dateTime->toDateTimeImmutable();
    }
}
