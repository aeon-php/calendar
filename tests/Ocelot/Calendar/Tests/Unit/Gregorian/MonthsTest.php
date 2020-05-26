<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit\Gregorian;

use Ocelot\Calendar\Gregorian\Month;
use Ocelot\Calendar\Gregorian\Year;
use PHPUnit\Framework\TestCase;

final class MonthsTest extends TestCase
{
    public function test_map_months() : void
    {
        $this->assertSame(
            \range(1, 12),
            (new Year(2020))->months()->map(fn(Month $month) => $month->number())
        );
    }

    public function test_filter_months() : void
    {
        $this->assertSame(
            [2, 4, 6, 8, 10, 12],
            \array_map(
                fn(Month $month) : int => $month->number(),
                \array_values((new Year(2020))->months()->filter(fn(Month $month) => $month->number() % 2 === 0))
            )
        );
    }
}