<?php

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 * @psalm-external-mutation-free
 */
final class Year
{
    private int $year;

    private Months $months;

    public function __construct(int $year)
    {
        $this->year = $year;
        $this->months = new Months($this);
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTime(\DateTimeImmutable $dateTime) : self
    {
        return new self((int) $dateTime->format('Y'));
    }

    public static function fromString(string $date) : self
    {
        return self::fromDateTime(new \DateTimeImmutable($date));
    }

    public function months(): Months
    {
        return $this->months;
    }

    public function number() : int
    {
        return $this->year;
    }

    public function numberOfMonths() : int
    {
        return $this->months->count();
    }

    public function isLeap() : bool
    {
        return (bool) $this->toDateTimeImmutable()->format('L');
    }

    private function toDateTimeImmutable() : \DateTimeImmutable
    {
        return (new \DateTimeImmutable('now'))->setDate($this->number(), 1, 1);
    }
}