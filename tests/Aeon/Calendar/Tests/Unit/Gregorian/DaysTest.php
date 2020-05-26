<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Year;
use PHPUnit\Framework\TestCase;

final class DaysTest extends TestCase
{
    public function test_count() : void
    {
        $this->assertSame(
            31,
            (new Month(new Year(2020), 01))->days()->count()
        );
    }

    public function test_first_day() : void
    {
        $this->assertSame(
            1,
            (new Month(new Year(2020), 01))->days()->first()->number()
        );
    }

    public function test_last_day() : void
    {
        $this->assertSame(
            31,
            (new Month(new Year(2020), 01))->days()->last()->number()
        );
    }

    public function test_map_days() : void
    {
        $this->assertSame(
            \range(1, 31),
            (new Month(new Year(2020), 01))->days()->map(fn(Day $day) => $day->number())
        );
    }

    public function test_filter_days() : void
    {
        $this->assertSame(
            [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30],
            \array_map(
                function(Day $day) : int {
                    return $day->number();
                },
                \array_values((new Month(new Year(2020), 01))->days()->filter(fn(Day $day) => $day->number() % 2 === 0))
            )
        );
    }
}