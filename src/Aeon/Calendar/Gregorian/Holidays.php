<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Gregorian\Holidays\Holiday;

interface Holidays
{
    public function isHoliday(Day $day) : bool;

    /**
     * @return array<Holiday>
     */
    public function holidaysAt(Day $day) : array;
}
