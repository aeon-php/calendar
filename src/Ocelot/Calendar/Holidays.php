<?php

namespace Ocelot\Ocelot\Calendar;

use Ocelot\Ocelot\Calendar\Gregorian\Day;
use Ocelot\Ocelot\Calendar\Holidays\Holiday;

interface Holidays
{
    public function isHoliday(Day $day) : bool;

    /**
     * @return array<Holiday>
     */
    public function holidaysAt(Day $day) : array;
}