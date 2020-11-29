<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Year;
use Aeon\Calendar\Gregorian\Years;
use PHPUnit\Framework\TestCase;

final class YearsTest extends TestCase
{
    public function test_array_access() : void
    {
        $years = new Years(
            Year::fromString('2000-01-01'),
            Year::fromString('2001-02-02'),
            Year::fromString('2002-03-03')
        );

        $this->assertTrue(isset($years[0]));
        $this->assertInstanceOf(Year::class, $years[0]);
        $this->assertSame(3, \iterator_count($years->getIterator()));
        $this->assertCount(3, $years->all());
    }

    public function test_map() : void
    {
        $yeras = new Years(
            Year::fromString('2000-01-01'),
            Year::fromString('2001-02-02'),
            Year::fromString('2002-03-03')
        );

        $this->assertSame(
            [2000, 2001, 2002],
            $yeras->map(function (Year $day) {
                return $day->number();
            })
        );
    }

    public function test_filter() : void
    {
        $years = new Years(
            Year::fromString('2000-01-01'),
            Year::fromString('2001-02-02'),
            Year::fromString('2002-03-03')
        );

        $this->assertEquals(
            new Years(Year::fromString('2000-01-01')),
            $years->filter(function (Year $day) {
                return $day->number() === 2000;
            })
        );
    }
}
