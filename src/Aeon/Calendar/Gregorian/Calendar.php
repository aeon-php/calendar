<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
interface Calendar
{
    public function currentYear() : Year;

    public function currentMonth() : Month;

    public function currentDay() : Day;

    public function yesterday() : Day;

    public function tomorrow() : Day;

    public function now() : DateTime;
}
