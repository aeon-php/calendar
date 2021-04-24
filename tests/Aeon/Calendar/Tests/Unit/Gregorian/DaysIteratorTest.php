<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\DaysIterator;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-immutable
 */
final class DaysIteratorTest extends TestCase
{
    public function test_reverse_days_iterator() : void
    {
        $begin = new \DateTime('2020-01-01 00:00:00 UTC');
        $end = new \DateTime('2020-01-10 00:00:00 UTC');

        $interval = new \DateInterval('P1D');

        $array = \iterator_to_array(DaysIterator::fromDatePeriod(new \DatePeriod($begin, $interval, $end))->reverse());

        $this->assertEquals($array[0], Day::fromString('2020-01-09 00:00:00 UTC'));
        $this->assertEquals($array[8], Day::fromString('2020-01-01 00:00:00 UTC'));
    }
}
