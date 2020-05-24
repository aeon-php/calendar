<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit\Gregorian;

use Ocelot\Calendar\Gregorian\DateTime;
use Ocelot\Calendar\Gregorian\TimeZone;
use PHPUnit\Framework\TestCase;

final class TimeZoneTest extends TestCase
{
    public function test_creating_from_invalid_name() : void
    {
        $this->expectExceptionMessage('"not_a_timezone" is not a valid timezone.');

        new TimeZone('not_a_timezone');
    }

    public function test_calculating_offset_for_date() : void
    {
        $tz = TimeZone::europeWarsaw();

        $this->assertSame('+01:00', $tz->timeOffset(DateTime::fromString('2020-01-01 12:00:00'))->toString());
        $this->assertSame(3600, $tz->timeOffset(DateTime::fromString('2020-01-01 12:00:00'))->toTimeUnit()->inSeconds());
        $this->assertSame('+02:00', $tz->timeOffset(DateTime::fromString('2020-06-01 12:00:00'))->toString());
        $this->assertSame(7200, $tz->timeOffset(DateTime::fromString('2020-06-01 12:00:00'))->toTimeUnit()->inSeconds());
    }
}