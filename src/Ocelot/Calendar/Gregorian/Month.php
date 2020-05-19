<?php

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @psalm-external-mutation-free
 */
final class Month
{
    private Year $year;

    private Days $days;

    private int $number;

    public function __construct(Year $year, int $number)
    {
        $this->year = $year;
        $this->number = $number;
        $this->days = new Days($this);
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTime(\DateTimeImmutable $dateTime) : self
    {
        return new self(
            new Year((int) $dateTime->format('Y')),
            (int) $dateTime->format('m')
        );
    }

    public static function fromString(string $date) : self
    {
        return self::fromDateTime(new \DateTimeImmutable($date));
    }

    public function number() : int
    {
        return $this->number;
    }

    public function year() : Year
    {
        return $this->year;
    }

    public function days(): Days
    {
        return $this->days;
    }

    public function numberOfDays() : int
    {
        return (int) $this->toDateTimeImmutable()->format('t');
    }

    public function shortName() : string
    {
        return $this->toDateTimeImmutable()->format('M');
    }

    public function name() : string
    {
        return $this->toDateTimeImmutable()->format('F');
    }

    private function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (new \DateTimeImmutable('now'))->setDate($this->year()->number(), $this->number(), 1);
    }
}