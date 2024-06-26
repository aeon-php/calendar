<?php
declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\GregorianCalendarStub;
use Aeon\Calendar\Gregorian\Psr20CalendarAdapter;
use Aeon\Calendar\Gregorian\TimeZone;
use PHPUnit\Framework\TestCase;

final class Psr20ClockAdapterTest extends TestCase
{
    public function test_now() : void
    {
        $date = DateTime::fromTimestampUnix(\time());
        $calendar = new GregorianCalendarStub(TimeZone::UTC(), $date);
        $sut = new Psr20CalendarAdapter($calendar);
        $this->assertEquals($date->toDateTimeImmutable(), $sut->now());
    }
}
