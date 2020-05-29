<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

interface Calendar
{
    public function currentYear() : Year;

    public function currentMonth() : Month;

    public function currentDay() : Day;

    public function now() : DateTime;

    public function yesterday() : DateTime;

    public function tomorrow() : DateTime;
}
