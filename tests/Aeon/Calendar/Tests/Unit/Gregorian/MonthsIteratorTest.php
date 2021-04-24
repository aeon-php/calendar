<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\MonthsIterator;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-immutable
 */
final class MonthsIteratorTest extends TestCase
{
    public function test_reverse_days_iterator() : void
    {
        $begin = new \DateTime('2020-01-01 00:00:00 UTC');
        $end = new \DateTime('2021-01-01 00:00:00 UTC');

        $interval = new \DateInterval('P1M');

        $array = \iterator_to_array(MonthsIterator::fromDatePeriod(new \DatePeriod($begin, $interval, $end))->reverse());

        $this->assertEquals($array[0], Month::fromString('2020-12-01 00:00:00 UTC'));
        $this->assertEquals($array[11], Month::fromString('2020-01-01 00:00:00 UTC'));
    }
}
