<?php

namespace Ocelot\Calendar;

use Ocelot\Calendar\Gregorian\Day;
use Ocelot\Calendar\Holidays\Holiday;

interface Holidays
{
    public function isHoliday(Day $day) : bool;

    /**
     * @return array<Holiday>
     */
    public function holidaysAt(Day $day) : array;
}