<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\LeapSecond;
use Aeon\Calendar\Gregorian\LeapSeconds;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class LeapSecondsTest extends TestCase
{
    /**
     * @runInSeparateProcess
     *
     * This test will start failing 5 days before expiration date of the current leap seconds list
     * Once it does please visit https://www.ietf.org/timezones/data/leap-seconds.list
     * and if there is a new leap second announced add it to the list or extend expiration
     * date according to the document.
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

    /**
     * @runInSeparateProcess
     */
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

    /**
     * @runInSeparateProcess
     */
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

    public function test_creating_leap_second_with_invalid_offset() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Leap second TAI offset must be greater or equal 10');

        new LeapSecond(DateTime::fromString('1970-01-01 00:00:00 UTC'), TimeUnit::seconds(5));
    }

    /**
     * @runInSeparateProcess
     */
    public function test_all_leap_seconds() : void
    {
        $leapSeconds = LeapSeconds::load();

        $this->assertSame(
            [
                10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
                20, 21, 22, 23, 24, 24, 25, 26, 27,
                28, 29, 30, 31, 32, 33, 34, 36, 37,
            ],
            \array_map(
                function (LeapSecond $leapSecond) : int {
                    return $leapSecond->offsetTAI()->inSeconds();
                },
                $leapSeconds->all()
            )
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test_filter_leap_seconds() : void
    {
        $leapSeconds = LeapSeconds::load();

        $this->assertSame(
            10,
            $leapSeconds->filter(fn (LeapSecond $leapSecond) => $leapSecond->offsetTAI()->inSeconds() === 10)->offsetTAI()->inSeconds()
        );
    }
}
