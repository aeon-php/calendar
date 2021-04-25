<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\DateTimeIterator;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\DaysIterator;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-immutable
 */
final class DaysIteratorTest extends TestCase
{
    public function test_reverse_days_iterator() : void
    {
        $begin = DateTime::fromString('2020-01-01 00:00:00 UTC');
        $end = DateTime::fromString('2020-01-10 00:00:00 UTC');

        $interval = TimeUnit::day();

        $array = \iterator_to_array(DaysIterator::fromDateTimeIterator(new DateTimeIterator($begin, $end, $interval))->reverse());

        $this->assertEquals($array[0], Day::fromString('2020-01-10 00:00:00 UTC'));
        $this->assertEquals($array[9], Day::fromString('2020-01-01 00:00:00 UTC'));
    }
}
