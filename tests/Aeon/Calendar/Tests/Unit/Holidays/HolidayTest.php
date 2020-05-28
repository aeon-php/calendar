<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Holidays;

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Holidays\Holiday;
use Aeon\Calendar\Gregorian\Holidays\HolidayLocaleName;
use Aeon\Calendar\Gregorian\Holidays\HolidayName;
use PHPUnit\Framework\TestCase;

final class HolidayTest extends TestCase
{
    public function test_holiday() : void
    {
        $holiday = new Holiday(
            Day::fromString('2020-01-01'),
            new HolidayName(new HolidayLocaleName('en', 'New Year'), new HolidayLocaleName('pl', 'Nowy Rok'))
        );

        $this->assertSame(1, $holiday->day()->number());
        $this->assertSame('New Year', $holiday->name('en'));
        $this->assertSame('Nowy Rok', $holiday->name('pl'));
        $this->assertSame(['en', 'pl'], $holiday->locales());
    }

    public function test_holiday_name_in_non_existing_locale() : void
    {
        $holiday = new Holiday(
            Day::fromString('2020-01-01'),
            new HolidayName(new HolidayLocaleName('en', 'New Year'), new HolidayLocaleName('pl', 'Nowy Rok'))
        );

        $this->expectExceptionMessage('Holiday "New Year" does not have name in br locale');

        $this->assertSame('New Year', $holiday->name('br'));
    }
}
