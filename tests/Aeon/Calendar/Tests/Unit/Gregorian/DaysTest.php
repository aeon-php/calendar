<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Days;
use PHPUnit\Framework\TestCase;

final class DaysTest extends TestCase
{
    public function test_array_access() : void
    {
        $days = new Days(
            Day::fromString('2002-01-01'),
            Day::fromString('2002-01-02'),
            Day::fromString('2002-01-03'),
        );

        $this->assertTrue(isset($days[0]));
        $this->assertInstanceOf(Day::class, $days[0]);
        $this->assertSame(3, \iterator_count($days->getIterator()));
    }

    public function test_map() : void
    {
        $days = new Days(
            Day::fromString('2002-01-01'),
            Day::fromString('2002-01-02'),
            Day::fromString('2002-01-03'),
        );

        $this->assertSame(
            [1, 2, 3],
            $days->map(function (Day $day) {
                return $day->number();
            })
        );
    }

    public function test_filter() : void
    {
        $days = new Days(
            Day::fromString('2002-01-01'),
            Day::fromString('2002-01-02'),
            Day::fromString('2002-01-03'),
        );

        $this->assertEquals(
            new Days(Day::fromString('2002-01-01')),
            $days->filter(function (Day $day) {
                return $day->number() === 1;
            })
        );
    }
}
