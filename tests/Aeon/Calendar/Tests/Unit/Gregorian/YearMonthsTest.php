<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Year;
use PHPUnit\Framework\TestCase;

final class YearMonthsTest extends TestCase
{
    public function test_count() : void
    {
        $this->assertSame(12, (new Year(2020))->months()->count());
        $this->assertCount(12, (new Year(2020))->months()->all());
    }

    public function test_map_months() : void
    {
        $this->assertSame(
            \range(1, 12),
            (new Year(2020))->months()->map(fn (Month $month) => $month->number())
        );
    }

    public function test_filter_months() : void
    {
        $this->assertSame(
            [2, 4, 6, 8, 10, 12],
            \array_map(
                fn (Month $month) : int => $month->number(),
                \array_values((new Year(2020))->months()->filter(fn (Month $month) => $month->number() % 2 === 0))
            )
        );
    }
}
