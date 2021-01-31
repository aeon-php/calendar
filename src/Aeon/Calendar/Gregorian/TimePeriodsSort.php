<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
final class TimePeriodsSort
{
    private const START_DATE_ASC = 1;

    private const START_DATE_DESC = 2;

    private const END_DATE_ASC = 3;

    private const END_DATE_DESC = 4;

    private int $type;

    private function __construct(int $type)
    {
        $this->type = $type;
    }

    /**
     * @psalm-pure
     */
    public static function asc() : self
    {
        return self::startDate();
    }

    /**
     * @psalm-pure
     */
    public static function desc() : self
    {
        return self::startDate(false);
    }

    /**
     * @psalm-pure
     */
    public static function startDate(bool $ascending = true) : self
    {
        return new self($ascending ? self::START_DATE_ASC : self::START_DATE_DESC);
    }

    /**
     * @psalm-pure
     */
    public static function endDate(bool $ascending = true) : self
    {
        return new self($ascending ? self::END_DATE_ASC : self::END_DATE_DESC);
    }

    public function byStartDate() : bool
    {
        return $this->type === self::START_DATE_ASC || $this->type === self::START_DATE_DESC;
    }

    public function isAscending() : bool
    {
        return $this->type === self::START_DATE_ASC || $this->type === self::END_DATE_ASC;
    }
}
