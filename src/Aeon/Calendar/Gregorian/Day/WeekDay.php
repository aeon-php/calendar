<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian\Day;

use Aeon\Calendar\Exception\InvalidArgumentException;

/**
 * @psalm-immutable
 */
final class WeekDay
{
    private const NAMES = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ];

    private const NAMES_SHORT = [
        1 => 'Mon',
        2 => 'Tue',
        3 => 'Wed',
        4 => 'Thu',
        5 => 'Fri',
        6 => 'Sat',
        7 => 'Sun',
    ];

    private int $number;

    public function __construct(int $number)
    {
        if ($number <= 0 || $number > 7) {
            throw new InvalidArgumentException('Day number must be greater or equal 1 and less or equal than 7');
        }

        $this->number = $number;
    }

    /**
     * @psalm-pure
     */
    public static function monday() : self
    {
        return new self(1);
    }

    /**
     * @psalm-pure
     */
    public static function tuesday() : self
    {
        return new self(2);
    }

    /**
     * @psalm-pure
     */
    public static function wednesday() : self
    {
        return new self(3);
    }

    /**
     * @psalm-pure
     */
    public static function thursday() : self
    {
        return new self(4);
    }

    /**
     * @psalm-pure
     */
    public static function friday() : self
    {
        return new self(5);
    }

    /**
     * @psalm-pure
     */
    public static function saturday() : self
    {
        return new self(6);
    }

    /**
     * @psalm-pure
     */
    public static function sunday() : self
    {
        return new self(7);
    }

    public function number() : int
    {
        return $this->number;
    }

    public function name() : string
    {
        return self::NAMES[$this->number];
    }

    public function shortName() : string
    {
        return self::NAMES_SHORT[$this->number];
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $weekDay) : bool
    {
        return $this->isEqualTo($weekDay);
    }

    public function isEqualTo(self $weekDay) : bool
    {
        return $this->number() === $weekDay->number();
    }

    public function isWeekend() : bool
    {
        return \in_array($this->number(), [6, 7], true);
    }
}
