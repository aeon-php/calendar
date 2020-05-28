<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian\Holidays;

use Aeon\Calendar\Exception\HolidayYearException;
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Holidays;
use Webmozart\Assert\Assert;

final class GoogleCalendarRegionalHolidays implements Holidays
{
    /**
     * @var array<int, string>
     */
    private array $countryCodes;

    /**
     * @var null|array<int, array<string, array<int, Holiday>>>
     */
    private ?array $calendars;

    public function __construct(string ...$countryCodes)
    {
        Assert::greaterThan(\count($countryCodes), 0);
        Assert::allInArray(
            $normalizedCountryCodes = \array_map(
                function (string $countryCode) : string {
                    return \mb_strtoupper($countryCode);
                },
                $countryCodes
            ),
            Holidays\GoogleCalendar\CountryCodes::all()
        );

        $this->countryCodes = \array_values($normalizedCountryCodes);
        $this->calendars = null;
    }

    public function isHoliday(Day $day) : bool
    {
        if ($this->calendars === null) {
            $this->loadCalendars();
        }

        /** @var array<int, array<string, array<int, Holiday>>> $calendars */
        $calendars = (array) $this->calendars;

        if (!\count($calendars)) {
            // @codeCoverageIgnoreStart
            throw new HolidayYearException("Holidays list is empty");
            // @codeCoverageIgnoreEnd
        }

        if (!\array_key_exists($day->year()->number(), $calendars)) {
            // @codeCoverageIgnoreStart
            throw new HolidayYearException(\sprintf("There are no holidays in %d, please check regional holidays data set.", $day->year()->number()));
            // @codeCoverageIgnoreStart
        }

        return isset($calendars[$day->year()->number()][$day->format('Y-m-d')]);
    }

    /**
     * @return array<Holiday>
     */
    public function holidaysAt(Day $day) : array
    {
        if ($this->calendars === null) {
            $this->loadCalendars();
        }

        /** @var array<int, array<string, array<int, Holiday>>> $calendars */
        $calendars = (array) $this->calendars;

        if (!\count($calendars)) {
            throw new HolidayYearException("Holidays list is empty");
        }

        if (!\array_key_exists($day->year()->number(), $calendars)) {
            throw new HolidayYearException(\sprintf("There are no holidays in %d, please check regional holidays data set.", $day->year()->number()));
        }

        if (isset($calendars[$day->year()->number()][$day->format('Y-m-d')])) {
            return $calendars[$day->year()->number()][$day->format('Y-m-d')];
        }

        return [];
    }

    private function loadCalendars() : void
    {
        if ($this->calendars !== null) {
            return ;
        }

        foreach ($this->countryCodes as $countryCode) {
            $this->loadCalendar($countryCode);
        }
    }

    private function loadCalendar(string $countryCode) : void
    {
        /**
         * @var array{
         *   country_code: string,
         *   name: string,
         *   timezones: array<int, string>,
         *   location: array<int, array<string, float>>,
         *   google_calendar: array<int, array{
         *     locale: string,
         *     calendar: string,
         *     years: array<int, array{
         *       year: int,
         *       holidays: array<int, array{date: string, name: string}>
         *     }>
         *   }>
         * } $data
         */
        $data = (array) \json_decode((string) \file_get_contents(__DIR__ . '/data/regional/' . $countryCode . '.json'), true, JSON_THROW_ON_ERROR);

        if ($this->calendars === null) {
            $this->calendars = [];
        }

        foreach ($data['google_calendar'] as $googleCalendar) {
            foreach ($googleCalendar['years'] as $googleCalendarYear) {
                if (!\array_key_exists($googleCalendarYear['year'], $this->calendars)) {
                    $this->calendars[$googleCalendarYear['year']] = [];
                }

                foreach ($googleCalendarYear['holidays'] as $holiday) {
                    if (!\array_key_exists($holiday['date'], $this->calendars[$googleCalendarYear['year']])) {
                        $this->calendars[$googleCalendarYear['year']][$holiday['date']] = [];
                    }

                    $this->calendars[$googleCalendarYear['year']][$holiday['date']][] = new Holiday(
                        Day::fromString($holiday['date']),
                        new HolidayName(new HolidayLocaleName($googleCalendar['locale'], $holiday['name']))
                    );
                }
            }
        }
    }
}
