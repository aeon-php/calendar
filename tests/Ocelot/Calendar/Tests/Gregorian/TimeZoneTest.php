<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Gregorian;

use Ocelot\Ocelot\Calendar\Gregorian\DateTime;
use Ocelot\Ocelot\Calendar\Gregorian\TimeZone;
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

        $this->assertSame('+01:00', $tz->offsetUTCString(DateTime::fromString('2020-01-01 12:00:00')));
        $this->assertSame(3600, $tz->offsetUTC(DateTime::fromString('2020-01-01 12:00:00'))->inSeconds());
        $this->assertSame('+02:00', $tz->offsetUTCString(DateTime::fromString('2020-06-01 12:00:00')));
        $this->assertSame(7200, $tz->offsetUTC(DateTime::fromString('2020-06-01 12:00:00'))->inSeconds());
    }
}