<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
interface Calendar
{
    public function timeZone() : TimeZone;

    public function currentYear() : Year;

    public function currentMonth() : Month;

    public function currentDay() : Day;

    public function yesterday() : DateTime;

    public function tomorrow() : DateTime;

    public function now() : DateTime;
}
