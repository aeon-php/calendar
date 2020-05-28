<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Functional\Holidays;

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Holidays\GoogleCalendar\CountryCodes;
use Aeon\Calendar\Gregorian\Holidays\GoogleCalendarRegionalHolidays;
use Aeon\Calendar\Gregorian\Holidays\Holiday;
use PHPUnit\Framework\TestCase;

final class GoogleCalendarRegionalHolidaysTest extends TestCase
{
    public function test_checking_regional_holidays() : void
    {
        $holidays = new GoogleCalendarRegionalHolidays(CountryCodes::PL);

        $this->assertTrue($holidays->isHoliday(Day::fromString('2020-01-01')));
        $this->assertFalse($holidays->isHoliday(Day::fromString('2020-01-02')));
    }

    public function test_getting_regional_holidays() : void
    {
        $holidays = new GoogleCalendarRegionalHolidays(CountryCodes::PL);

        $this->assertCount(1, $holidays->holidaysAt(Day::fromString('2020-01-01')));
        $this->assertInstanceOf(Holiday::class, $holidays->holidaysAt(Day::fromString('2020-01-01'))[0]);
    }

    public function test_getting_regional_holidays_from_multiple_regions() : void
    {
        $holidays = new GoogleCalendarRegionalHolidays(CountryCodes::PL, CountryCodes::US);

        $this->assertCount(2, $holidays->holidaysAt(Day::fromString('2020-01-01')));
        $this->assertInstanceOf(Holiday::class, $holidays->holidaysAt(Day::fromString('2020-01-01'))[0]);
        $this->assertInstanceOf(Holiday::class, $holidays->holidaysAt(Day::fromString('2020-01-01'))[1]);
        $this->assertSame('New Year\'s Day', $holidays->holidaysAt(Day::fromString('2020-01-01'))[0]->name());
        $this->assertSame('New Year\'s Day', $holidays->holidaysAt(Day::fromString('2020-01-01'))[1]->name());
    }
}
