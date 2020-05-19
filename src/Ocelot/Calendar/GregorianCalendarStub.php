<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar;

use Ocelot\Ocelot\Calendar\Gregorian\DateTime;
use Ocelot\Ocelot\Calendar\Gregorian\Day;
use Ocelot\Ocelot\Calendar\Gregorian\Month;
use Ocelot\Ocelot\Calendar\Gregorian\Year;

final class GregorianCalendarStub implements SolarCalendar
{
    private ?\DateTimeImmutable $currentDate;

    public function __construct(?\DateTimeImmutable $currentDate = null)
    {
        $this->currentDate = $currentDate;
    }

    public function year(): Year
    {
        return Year::fromDateTime($this->now()->toDateTimeImmutable());
    }

    public function month(): Month
    {
        return Month::fromDateTime($this->now()->toDateTimeImmutable());
    }

    public function day(): Day
    {
        return Day::fromDateTime($this->now()->toDateTimeImmutable());
    }

    public function now(): DateTime
    {
        return $this->currentDate ? DateTime::fromDateTime($this->currentDate) : DateTime::fromString('now');
    }

    public function setNow(DateTime $dateTime) : void
    {
        $this->currentDate = $dateTime->toDateTimeImmutable();
    }
}