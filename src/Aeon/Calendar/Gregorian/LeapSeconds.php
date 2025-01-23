<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class LeapSeconds
{
    private static ?self $instance = null;

    private DateTime $listExpirationDate;

    /**
     * @var array<LeapSecond>
     */
    private array $leapSeconds;

    private function __construct(DateTime $listExpiration, LeapSecond ...$leapSeconds)
    {
        $this->leapSeconds = $leapSeconds;
        $this->listExpirationDate = $listExpiration;
    }

    /**
     * List taken from https://www.ietf.org/timezones/data/leap-seconds.list.
     *
     * Leap seconds are announced by https://www.iers.org/ (The International Earth Rotation and Reference Systems Service)
     * in their Bulletin C, list of all available releases https://www.iers.org/IERS/EN/Publications/Bulletins/bulletins.html
     *
     * @psalm-pure
     *
     * @psalm-suppress ImpureStaticProperty
     */
    public static function load() : self
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        self::$instance = new self(
            DateTime::fromString('2025-12-28 00:00:00 UTC'),
            new LeapSecond(DateTime::fromString('1972-01-01 00:00:00 UTC'), TimeUnit::seconds(10)),
            new LeapSecond(DateTime::fromString('1972-07-01 00:00:00 UTC'), TimeUnit::seconds(11)),
            new LeapSecond(DateTime::fromString('1973-01-01 00:00:00 UTC'), TimeUnit::seconds(12)),
            new LeapSecond(DateTime::fromString('1974-01-01 00:00:00 UTC'), TimeUnit::seconds(13)),
            new LeapSecond(DateTime::fromString('1975-01-01 00:00:00 UTC'), TimeUnit::seconds(14)),
            new LeapSecond(DateTime::fromString('1976-01-01 00:00:00 UTC'), TimeUnit::seconds(15)),
            new LeapSecond(DateTime::fromString('1977-01-01 00:00:00 UTC'), TimeUnit::seconds(16)),
            new LeapSecond(DateTime::fromString('1978-01-01 00:00:00 UTC'), TimeUnit::seconds(17)),
            new LeapSecond(DateTime::fromString('1979-01-01 00:00:00 UTC'), TimeUnit::seconds(18)),
            new LeapSecond(DateTime::fromString('1980-01-01 00:00:00 UTC'), TimeUnit::seconds(19)),
            new LeapSecond(DateTime::fromString('1981-07-01 00:00:00 UTC'), TimeUnit::seconds(20)),
            new LeapSecond(DateTime::fromString('1982-07-01 00:00:00 UTC'), TimeUnit::seconds(21)),
            new LeapSecond(DateTime::fromString('1983-07-01 00:00:00 UTC'), TimeUnit::seconds(22)),
            new LeapSecond(DateTime::fromString('1985-07-01 00:00:00 UTC'), TimeUnit::seconds(23)),
            new LeapSecond(DateTime::fromString('1988-01-01 00:00:00 UTC'), TimeUnit::seconds(24)),
            new LeapSecond(DateTime::fromString('1990-01-01 00:00:00 UTC'), TimeUnit::seconds(24)),
            new LeapSecond(DateTime::fromString('1991-01-01 00:00:00 UTC'), TimeUnit::seconds(25)),
            new LeapSecond(DateTime::fromString('1992-07-01 00:00:00 UTC'), TimeUnit::seconds(26)),
            new LeapSecond(DateTime::fromString('1993-07-01 00:00:00 UTC'), TimeUnit::seconds(27)),
            new LeapSecond(DateTime::fromString('1994-07-01 00:00:00 UTC'), TimeUnit::seconds(28)),
            new LeapSecond(DateTime::fromString('1996-01-01 00:00:00 UTC'), TimeUnit::seconds(29)),
            new LeapSecond(DateTime::fromString('1997-07-01 00:00:00 UTC'), TimeUnit::seconds(30)),
            new LeapSecond(DateTime::fromString('1999-01-01 00:00:00 UTC'), TimeUnit::seconds(31)),
            new LeapSecond(DateTime::fromString('2006-01-01 00:00:00 UTC'), TimeUnit::seconds(32)),
            new LeapSecond(DateTime::fromString('2009-01-01 00:00:00 UTC'), TimeUnit::seconds(33)),
            new LeapSecond(DateTime::fromString('2012-07-01 00:00:00 UTC'), TimeUnit::seconds(34)),
            new LeapSecond(DateTime::fromString('2015-07-01 00:00:00 UTC'), TimeUnit::seconds(36)),
            new LeapSecond(DateTime::fromString('2017-01-01 00:00:00 UTC'), TimeUnit::seconds(37)),
        );

        return self::$instance;
    }

    public function expirationDate() : DateTime
    {
        return $this->listExpirationDate;
    }

    public function since(DateTime $dateTime) : self
    {
        return $this->filter(function (LeapSecond $leapSecond) use ($dateTime) : bool {
            return $dateTime
                    ->toTimeZone(TimeZone::UTC())
                    ->isBefore($leapSecond->dateTime());
        });
    }

    public function until(DateTime $dateTime) : self
    {
        return $this->filter(function (LeapSecond $leapSecond) use ($dateTime) : bool {
            return $dateTime
                ->toTimeZone(TimeZone::UTC())
                ->isAfterOrEqualTo($leapSecond->dateTime());
        });
    }

    public function findAllBetween(TimePeriod $timePeriod) : self
    {
        return $this->filter(function (LeapSecond $leapSecond) use ($timePeriod) : bool {
            return $timePeriod->start()
                    ->toTimeZone(TimeZone::UTC())
                    ->isBeforeOrEqualTo($leapSecond->dateTime())
                && $timePeriod->end()
                    ->toTimeZone(TimeZone::UTC())
                    ->isAfter($leapSecond->dateTime());
        });
    }

    public function offsetTAI() : TimeUnit
    {
        return $this->leapSeconds[\count($this->leapSeconds) - 1]->offsetTAI();
    }

    /**
     * @psalm-param pure-callable(LeapSecond $leapSecond) : bool $filter
     *
     * @param callable(LeapSecond $leapSecond) : bool $filter
     */
    public function filter(callable $filter) : self
    {
        return new self(
            $this->expirationDate(),
            ...\array_filter($this->all(), $filter)
        );
    }

    public function count() : TimeUnit
    {
        return TimeUnit::seconds(\count($this->all()));
    }

    /**
     * @return array<LeapSecond>
     */
    public function all() : array
    {
        return $this->leapSeconds;
    }
}
