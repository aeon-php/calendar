<?php

namespace Ocelot\Calendar\Gregorian;

use Ocelot\Calendar\Gregorian\Day;
use Ocelot\Calendar\Gregorian\Holidays\Holiday;

interface Holidays
{
    public function isHoliday(Day $day) : bool;

    /**
     * @return array<Holiday>
     */
    public function holidaysAt(Day $day) : array;
}