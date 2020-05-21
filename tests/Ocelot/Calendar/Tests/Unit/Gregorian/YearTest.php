<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit\Gregorian;

use Ocelot\Ocelot\Calendar\Gregorian\Year;
use PHPUnit\Framework\TestCase;

final class YearTest extends TestCase
{
    public function test_months() : void
    {
        $this->assertSame(1, Year::fromString('2020-01-01')->january()->number());
        $this->assertSame(2, Year::fromString('2020-01-01')->february()->number());
        $this->assertSame(3, Year::fromString('2020-01-01')->march()->number());
        $this->assertSame(4, Year::fromString('2020-01-01')->april()->number());
        $this->assertSame(5, Year::fromString('2020-01-01')->may()->number());
        $this->assertSame(6, Year::fromString('2020-01-01')->june()->number());
        $this->assertSame(7, Year::fromString('2020-01-01')->july()->number());
        $this->assertSame(8, Year::fromString('2020-01-01')->august()->number());
        $this->assertSame(9, Year::fromString('2020-01-01')->september()->number());
        $this->assertSame(10, Year::fromString('2020-01-01')->october()->number());
        $this->assertSame(11, Year::fromString('2020-01-01')->november()->number());
        $this->assertSame(12, Year::fromString('2020-01-01')->december()->number());
    }
}