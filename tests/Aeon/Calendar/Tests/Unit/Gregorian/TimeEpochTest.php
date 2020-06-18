<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\TimeEpoch;
use PHPUnit\Framework\TestCase;

final class TimeEpochTest extends TestCase
{
    /**
     * @dataProvider seconds_since_data_provider
     */
    public function test_distance_to_epoch(TimeEpoch $epoch, TimeEpoch $sinceEpoch, DateTime $dateTime, DateTime $sinceDateTime) : void
    {
        $this->assertSame(
            $epoch->distanceTo($sinceEpoch)->inSeconds(),
            $dateTime->until($sinceDateTime)->distance()->inSeconds()
        );
    }

    /**
     * @return \Generator<int, array{TimeEpoch, TimeEpoch, DateTime, DateTime}, mixed, void>
     */
    public function seconds_since_data_provider() : \Generator
    {
        yield [TimeEpoch::UTC(), TimeEpoch::GPS(), DateTime::fromString('1972-01-01 00:00:00 UTC'), DateTime::fromString('1980-01-06 00:00:00 UTC')];
        yield [TimeEpoch::UTC(), TimeEpoch::TAI(), DateTime::fromString('1972-01-01 00:00:00 UTC'), DateTime::fromString('1958-01-01 00:00:00 UTC')];
        yield [TimeEpoch::UTC(), TimeEpoch::UNIX(), DateTime::fromString('1972-01-01 00:00:00 UTC'), DateTime::fromString('1970-01-01 00:00:00 UTC')];
        yield [TimeEpoch::UTC(), TimeEpoch::UTC(), DateTime::fromString('1972-01-01 00:00:00 UTC'), DateTime::fromString('1972-01-01 00:00:00 UTC')];

        yield [TimeEpoch::GPS(), TimeEpoch::UTC(), DateTime::fromString('1980-01-06 00:00:00 UTC'), DateTime::fromString('1972-01-01 00:00:00 UTC')];
        yield [TimeEpoch::GPS(), TimeEpoch::TAI(), DateTime::fromString('1980-01-06 00:00:00 UTC'), DateTime::fromString('1958-01-01 00:00:00 UTC')];
        yield [TimeEpoch::GPS(), TimeEpoch::UNIX(), DateTime::fromString('1980-01-06 00:00:00 UTC'), DateTime::fromString('1970-01-01 00:00:00 UTC')];
        yield [TimeEpoch::GPS(), TimeEpoch::GPS(), DateTime::fromString('1980-01-06 00:00:00 UTC'), DateTime::fromString('1980-01-06 00:00:00 UTC')];

        yield [TimeEpoch::UNIX(), TimeEpoch::UTC(), DateTime::fromString('1970-01-01 00:00:00 UTC'), DateTime::fromString('1972-01-01 00:00:00 UTC')];
        yield [TimeEpoch::UNIX(), TimeEpoch::TAI(), DateTime::fromString('1970-01-01 00:00:00 UTC'), DateTime::fromString('1958-01-01 00:00:00 UTC')];
        yield [TimeEpoch::UNIX(), TimeEpoch::GPS(), DateTime::fromString('1970-01-01 00:00:00 UTC'), DateTime::fromString('1980-01-06 00:00:00 UTC')];
        yield [TimeEpoch::POSIX(), TimeEpoch::POSIX(), DateTime::fromString('1970-01-01 00:00:00 UTC'), DateTime::fromString('1970-01-01 00:00:00 UTC')];

        yield [TimeEpoch::TAI(), TimeEpoch::UTC(), DateTime::fromString('1958-01-01 00:00:00 UTC'), DateTime::fromString('1972-01-01 00:00:00 UTC')];
        yield [TimeEpoch::TAI(), TimeEpoch::GPS(), DateTime::fromString('1958-01-01 00:00:00 UTC'), DateTime::fromString('1980-01-06 00:00:00 UTC')];
        yield [TimeEpoch::TAI(), TimeEpoch::UNIX(), DateTime::fromString('1958-01-01 00:00:00 UTC'), DateTime::fromString('1970-01-01 00:00:00 UTC')];
        yield [TimeEpoch::TAI(), TimeEpoch::TAI(), DateTime::fromString('1958-01-01 00:00:00 UTC'), DateTime::fromString('1958-01-01 00:00:00 UTC')];
    }
}
