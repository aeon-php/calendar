<?php

declare(strict_types=1);

namespace Aeon\Calendar\Benchmark\Gregorian;

use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\Interval;

/**
 * @revs(50)
 *
 * @iterations(10)*
 *
 * @outputTimeUnit("milliseconds")
 */
final class DayIterationBench
{
    public function bench_aeon_iteration_over_last_half_of_the_year() : void
    {
        $end = GregorianCalendar::UTC()->currentDay();
        $start = $end->subMonths(6);

        $days = [];

        foreach ($start->until($end, Interval::rightOpen())->all() as $nextDay) {
            $days[] = $nextDay->format('Y-m-d');
        }
    }

    public function bench_php_iteration_over_last_half_of_the_year() : void
    {
        \date_default_timezone_set('UTC');

        $end = new \DateTime('today');
        $start = new \DateTime('-6 months');

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start, $interval, $end);

        $days = [];

        foreach ($period as $nextDay) {
            $days[] = $nextDay->format('Y-m-d');
        }
    }
}
