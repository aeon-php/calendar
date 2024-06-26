<?php
declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Psr\Clock\ClockInterface;

final class Psr20CalendarAdapter implements ClockInterface
{
    public function __construct(private readonly Calendar $calendar)
    {
    }

    public function now() : \DateTimeImmutable
    {
        return $this->calendar->now()->toDateTimeImmutable();
    }
}
