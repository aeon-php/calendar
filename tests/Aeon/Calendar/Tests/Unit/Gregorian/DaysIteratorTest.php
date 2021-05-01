<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\DateTimeIntervalIterator;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\DaysIterator;
use Aeon\Calendar\Gregorian\Interval;
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

        $timeUnit = TimeUnit::day();

        $array = \iterator_to_array(
            DaysIterator::fromDateTimeIterator(new DateTimeIntervalIterator($begin, $end, $timeUnit, Interval::closed()))
                ->reverse()
        );

        $this->assertEquals($array[0], Day::fromString('2020-01-10 00:00:00 UTC'));
        $this->assertEquals($array[9], Day::fromString('2020-01-01 00:00:00 UTC'));
    }
}
