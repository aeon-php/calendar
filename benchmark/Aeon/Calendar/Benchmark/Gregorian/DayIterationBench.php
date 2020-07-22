<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\Gregorian\TimeZone;

/**
 * @iterations(5)
 * @revs(5)
 * @outputTimeUnit("milliseconds")
 */
final class DayIterationBench
{
    public function bench_iteration_over_last_half_of_the_year_multiple_times() : void
    {
        $end = GregorianCalendar::UTC()->currentDay();
        $middle = $end->minusMonths(3);
        $start = $end->minusMonths(6);

        for ($index = 0; $index < 20; $index++) {
            foreach ($start->until($end)->all() as $nextDay) {
                if ($nextDay->isAfter($middle)) {
                    (new TimePeriod($nextDay->midnight($tz = TimeZone::UTC()), $nextDay->next()->midnight($tz)))
                        ->overlaps(new TimePeriod($nextDay->midnight($tz), $nextDay->previous()->midnight($tz)));
                }
            }
        }
    }
}
