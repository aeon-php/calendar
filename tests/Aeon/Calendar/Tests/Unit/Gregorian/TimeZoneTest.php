<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\TimeZone;
use PHPUnit\Framework\TestCase;

final class TimeZoneTest extends TestCase
{
    public function test_creating_from_invalid_string() : void
    {
        $this->expectExceptionMessage('"not_a_timezone" is not a valid time zone.');

        TimeZone::fromString('not_a_timezone');
    }

    public function test_creating_from_invalid_abbreviation() : void
    {
        $this->expectExceptionMessage('"not_a_timezone" is not a valid timezone abbreviation.');

        TimeZone::abbreviation('not_a_timezone');
    }

    public function test_creating_from_invalid_identifier() : void
    {
        $this->expectExceptionMessage('"not_a_timezone" is not a valid timezone identifier.');

        TimeZone::id('not_a_timezone');
    }

    public function test_creating_from_invalid_offset() : void
    {
        $this->expectExceptionMessage('"not_a_timezone" is not a valid time offset.');

        TimeZone::offset('not_a_timezone');
    }

    public function test_creating_from_invalid_static_name() : void
    {
        $this->expectExceptionMessage('"blabla" is not a valid time zone identifier or abbreviation.');
        $tz = TimeZone::blabla();
    }

    public function test_creating_from_offset() : void
    {
        $tz = TimeZone::fromString('+0100');
        $this->assertSame('+01:00', $tz->name());
        $this->assertTrue($tz->isOffset());
        $this->assertFalse($tz->isAbbreviation());
        $this->assertFalse($tz->isIdentifier());
    }

    public function test_creating_from_abbreviation() : void
    {
        $tz = TimeZone::fromString('gmt');
        $this->assertSame('GMT', $tz->name());
        $this->assertTrue($tz->isAbbreviation());
        $this->assertFalse($tz->isOffset());
        $this->assertFalse($tz->isIdentifier());
    }

    public function test_creating_from_id() : void
    {
        $tz = TimeZone::fromString('Europe/Warsaw');
        $this->assertSame('Europe/Warsaw', $tz->name());
        $this->assertTrue($tz->isIdentifier());
        $this->assertFalse($tz->isAbbreviation());
        $this->assertFalse($tz->isOffset());
    }

    public function test_creating_from_static_id() : void
    {
        $tz = TimeZone::europeWarsaw();
        $this->assertSame('Europe/Warsaw', $tz->name());
    }

    public function test_creating_from_static_abbreviation() : void
    {
        $tz = TimeZone::GMT();
        $this->assertSame('GMT', $tz->name());
    }

    public function test_calculating_offset_for_date() : void
    {
        $tz = TimeZone::europeWarsaw();

        $this->assertSame('+01:00', $tz->timeOffset(DateTime::fromString('2020-01-01 12:00:00'))->toString());
        $this->assertSame(3600, $tz->timeOffset(DateTime::fromString('2020-01-01 12:00:00'))->toTimeUnit()->inSeconds());
        $this->assertSame('+02:00', $tz->timeOffset(DateTime::fromString('2020-06-01 12:00:00'))->toString());
        $this->assertSame(7200, $tz->timeOffset(DateTime::fromString('2020-06-01 12:00:00'))->toTimeUnit()->inSeconds());
    }

    public function test_is_valid() : void
    {
        $this->assertFalse(TimeZone::isValid('invalid_time_zone'));
        $this->assertTrue(TimeZone::isValid('Europe/Warsaw'));
    }

    public function test_all_timezone_identifiers() : void
    {
        $this->assertCount(\count(\DateTimeZone::listIdentifiers()), TimeZone::allIdentifiers());
        $this->assertContainsOnlyInstancesOf(TimeZone::class, TimeZone::allIdentifiers());
    }

    public function test_all_timezones() : void
    {
        $this->assertCount(\count(\array_keys(\DateTimeZone::listAbbreviations())), TimeZone::allAbbreviations());
        $this->assertContainsOnlyInstancesOf(TimeZone::class, TimeZone::allAbbreviations());
    }

    public function test_serialization() : void
    {
        $timeZone = TimeZone::fromString('America/Los_Angeles');

        $this->assertSame(
            [
                'name' => 'America/Los_Angeles',
            ],
            $serializedTimeZone = $timeZone->__serialize()
        );
        $this->assertSame(
            'O:32:"' . TimeZone::class . '":1:{s:4:"name";s:19:"America/Los_Angeles";}',
            $serializedTimeZoneString = \serialize($timeZone)
        );
        $this->assertEquals(
            \unserialize($serializedTimeZoneString),
            $timeZone
        );
    }
}
