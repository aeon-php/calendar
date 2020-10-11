<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\TimeZone;
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

    public function test_converting_to_country_code() : void
    {
        $this->assertSame('PL', TimeZone::europeWarsaw()->toCountryCode());
    }

    public function test_is_valid() : void
    {
        $this->assertFalse(TimeZone::isValid('invalid_time_zone'));
        $this->assertTrue(TimeZone::isValid('Europe/Warsaw'));
        $this->assertTrue(TimeZone::isValid(TimeZone::AMERICA_GODTHAB));
        $this->assertTrue(TimeZone::isValid(TimeZone::PACIFIC_JOHNSTON));
    }

    public function test_all_timezones() : void
    {
        $this->assertCount(418, TimeZone::all());
    }
}
