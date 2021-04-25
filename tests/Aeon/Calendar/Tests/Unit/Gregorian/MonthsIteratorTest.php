<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\DateTimeIterator;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\MonthsIterator;
use Aeon\Calendar\RelativeTimeUnit;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-immutable
 */
final class MonthsIteratorTest extends TestCase
{
    public function test_reverse_days_iterator() : void
    {
        $begin = DateTime::fromString('2020-01-01 00:00:00 UTC');
        $end = DateTime::fromString('2021-01-01 00:00:00 UTC');

        $timeUnit = RelativeTimeUnit::month();

        $array = \iterator_to_array(MonthsIterator::fromDateTimeIterator(new DateTimeIterator($begin, $end, $timeUnit))->reverse());

        $this->assertEquals($array[0], Month::fromString('2021-01-01 00:00:00 UTC'));
        $this->assertEquals($array[12], Month::fromString('2020-01-01 00:00:00 UTC'));
    }
}
