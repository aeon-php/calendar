<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class GregorianCalendar implements Calendar
{
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
        return DateTime::fromDateTime(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
    }

    public function yesterday() : DateTime
    {
        return new DateTime($this->day()->previous(), new Time(0, 0, 0, 0));
    }

    public function tomorrow() : DateTime
    {
        return new DateTime($this->day()->next(), new Time(0, 0, 0, 0));
    }
}