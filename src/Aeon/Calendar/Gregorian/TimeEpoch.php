<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class TimeEpoch
{
    public const UNIX = 0;

    public const UTC = 1;

    public const TAI = 2;

    public const GPS = 3;

    private int $type;

    private DateTime $dateTime;

    private function __construct(int $type, DateTime $dateTime)
    {
        $this->type = $type;
        $this->dateTime = $dateTime;
    }

    /**
     * Unix Epoch, started at 1970-01-01 00:00:00 UTC, not including leap seconds.
     *
     * @psalm-pure
     */
    public static function UNIX() : self
    {
        return new self(self::UNIX, DateTime::fromString('1970-01-01 00:00:00 UTC'));
    }

    /**
     * Other name for UNIX epoch.
     *
     * @psalm-pure
     */
    public static function POSIX() : self
    {
        return self::UNIX();
    }

    /**
     * UTC Epoch, started at 1972-01-01 00:00:00 UTC, including leap seconds.
     *
     * @psalm-pure
     */
    public static function UTC() : self
    {
        return new self(self::UTC, DateTime::fromString('1972-01-01 00:00:00 UTC'));
    }

    /**
     * GPS Epoch, started at 1980-01-06 00:00:00 UTC, including leap seconds
     * except first 9 there were added before epoch.
     *
     * @psalm-pure
     */
    public static function GPS() : self
    {
        return new self(self::GPS, DateTime::fromString('1980-01-06 00:00:00 UTC'));
    }

    /**
     * TAI Epoch, started at 1958-01-01 00:00:00 UTC, including leap seconds.
     *
     * @psalm-pure
     */
    public static function TAI() : self
    {
        return new self(self::TAI, DateTime::fromString('1958-01-01 00:00:00 UTC'));
    }

    public function type() : int
    {
        return $this->type;
    }

    public function date() : DateTime
    {
        return $this->dateTime;
    }

    /**
     * Returns difference in seconds between epoches without leap seconds.
     */
    public function distanceTo(self $timeEpoch) : TimeUnit
    {
        switch ($this->type) {
            case self::UTC:
                switch ($timeEpoch->type()) {
                    case self::GPS:
                        return TimeUnit::seconds(252892800); // 1972-01-01 00:00:00 UTC - 1980-01-06 00:00:00 UTC
                    case self::UNIX:
                        return TimeUnit::seconds(63072000)->invert();  // 1972-01-01 00:00:00 UTC - 1970-01-01 00:00:00 UTC
                    case self::TAI:
                        return TimeUnit::seconds(441763200)->invert(); // 1972-01-01 00:00:00 UTC - 1958-01-01 00:00:00 UTC

                    default:
                        return TimeUnit::seconds(0);
                }
                // no break
            case self::GPS:
                switch ($timeEpoch->type()) {
                    case self::UTC:
                        return TimeUnit::seconds(252892800)->invert(); // 1980-01-06 00:00:00 UTC - 1972-01-01 00:00:00 UTC
                    case self::UNIX:
                        return TimeUnit::seconds(315964800)->invert(); // 1980-01-06 00:00:00 UTC - 1970-01-01 00:00:00 UTC
                    case self::TAI:
                        return TimeUnit::seconds(694656000)->invert(); // 1980-01-06 00:00:00 UTC - 1958-01-01 00:00:00 UTC

                    default:
                        return TimeUnit::seconds(0);
                }
                // no break
            case self::TAI:
                switch ($timeEpoch->type()) {
                    case self::UTC:
                        return TimeUnit::seconds(441763200); // 1958-01-01 00:00:00 UTC - 1972-01-01 00:00:00 UTC
                    case self::UNIX:
                        return TimeUnit::seconds(378691200); // 1958-01-01 00:00:00 UTC - 1970-01-00 00:00:00 UTC
                    case self::GPS:
                        return TimeUnit::seconds(694656000); // 1958-01-01 00:00:00 UTC - 1980-01-06 00:00:00 UTC

                    default:
                        return TimeUnit::seconds(0);
                }

                // no break
            default: // UNIX
                switch ($timeEpoch->type()) {
                    case self::UTC:
                        return TimeUnit::seconds(63072000);  // 1970-01-01 00:00:00 UTC - 1972-01-01 00:00:00 UTC
                    case self::GPS:
                        return TimeUnit::seconds(315964800); // 1970-01-01 00:00:00 UTC - 1980-01-06 00:00:00 UTC
                    case self::TAI:
                        return TimeUnit::seconds(378691200)->invert(); // 1970-01-01 00:00:00 UTC - 1958-01-01 00:00:00 UTC

                    default:
                        return TimeUnit::seconds(0);
                }
        }
    }
}
