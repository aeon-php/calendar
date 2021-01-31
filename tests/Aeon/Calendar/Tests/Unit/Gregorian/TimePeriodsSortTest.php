<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\TimePeriodsSort;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-immutable
 */
final class TimePeriodsSortTest extends TestCase
{
    public function test_sort_by_start_date() : void
    {
        $this->assertEquals(TimePeriodsSort::asc(), TimePeriodsSort::startDate(true));
        $this->assertEquals(TimePeriodsSort::desc(), TimePeriodsSort::startDate(false));
        $this->assertTrue(TimePeriodsSort::startDate(true)->isAscending());
        $this->assertTrue(TimePeriodsSort::startDate(true)->byStartDate());
        $this->assertFalse(TimePeriodsSort::startDate(false)->isAscending());
    }

    public function test_sort_by_end_date() : void
    {
        $this->assertTrue(TimePeriodsSort::endDate(true)->isAscending());
        $this->assertFalse(TimePeriodsSort::endDate(true)->byStartDate());
        $this->assertFalse(TimePeriodsSort::endDate(false)->isAscending());
    }
}
