<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class GregorianCalendar implements Calendar
{
    /**
     * @var TimeZone
     */
    private TimeZone $timeZone;

    public function __construct(TimeZone $timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public static function UTC() : self
    {
        return new self(TimeZone::UTC());
    }

    public static function systemDefault() : self
    {
        return new self(new TimeZone(\date_default_timezone_get()));
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
        return DateTime::fromDateTime(new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->toTimeZone($this->timeZone);
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