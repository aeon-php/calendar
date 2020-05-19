<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Gregorian;

use Ocelot\Ocelot\Calendar\Gregorian\DateTime;
use Ocelot\Ocelot\Calendar\Gregorian\Period;
use PHPUnit\Framework\TestCase;

final class TimePeriodTest extends TestCase
{
    public function test_distance_in_time_unit_from_start_to_end_date() : void
    {
        $period = new Period(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $this->assertSame(86400, $period->distanceStartToEnd()->inSeconds());
        $this->assertFalse($period->distanceStartToEnd()->isNegative());
    }

    public function test_distance_in_time_unit_from_end_to_start_date() : void
    {
        $period = new Period(
            DateTime::fromString('2020-01-01 00:00:00.0000'),
            DateTime::fromString('2020-01-02 00:00:00.0000')
        );

        $this->assertSame(86400, $period->distanceEndToStart()->inSeconds());
        $this->assertTrue($period->distanceEndToStart()->isNegative());
    }
}