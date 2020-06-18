<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\LeapSeconds;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class LeapSecondsTest extends TestCase
{
    /**
     * This test will start failing 5 days before expiration date of the current leap seconds list
     * Once it does please visit https://www.ietf.org/timezones/data/leap-seconds.list
     * and if there is a new leap second announced add it to the list or extend expiration
     * date according to the document
     */
    public function test_expiration_of_current_leap_seconds_list() : void
    {
        $leapSeconds = LeapSeconds::load();

        $this->assertFalse(
            $leapSeconds->expirationDate()->isBefore(
                GregorianCalendar::UTC()->now()->add(TimeUnit::days(5))
            )
        );
        $this->assertSame(
            37,
            $leapSeconds->offsetTAI()->inSeconds()
        );
    }

    public function test_finding_leap_seconds_between_1970_jan_1_and_1980_jan_1() : void
    {
        $leapSeconds = LeapSeconds::load();

        $this->assertEquals(
            19,
            $leapSeconds->findAllBetween(
                DateTime::fromString('1970-01-01 00:00:00 UTC')->until(DateTime::fromString('1980-01-06 00:00:00 UTC'))
            )->offsetTAI()->inSeconds()
        );
        $this->assertSame(
            9,
            $leapSeconds->findAllBetween(
                DateTime::fromString('1970-01-01 00:00:00 UTC')->until(DateTime::fromString('1980-01-01 00:00:00 UTC'))
            )->count()
                ->inSeconds()
        );
    }

    public function test_finding_leap_seconds_since_date() : void
    {
        $leapSeconds = LeapSeconds::load();

        $this->assertSame(
            28,
            $leapSeconds->since(
                DateTime::fromString('1970-01-01 00:00:00 UTC')
            )->count()
                ->inSeconds()
        );
    }
}
