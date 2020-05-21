<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Gregorian;

use Ocelot\Ocelot\Calendar\Gregorian\Day;
use PHPUnit\Framework\TestCase;

final class DayTest extends TestCase
{
    public function test_midnight() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01T00:00:00+0000', $day->midnight()->toISO8601());
    }

    public function test_noon() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01T12:00:00+0000', $day->noon()->toISO8601());
    }

    public function test_end_of_day() : void
    {
        $day = Day::fromString('2020-01-01');

        $this->assertSame('2020-01-01 23:59:59.999999+0000', $day->endOfDay()->format('Y-m-d H:i:s.uO'));
    }
}