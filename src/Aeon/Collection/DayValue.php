<?php

declare(strict_types=1);

namespace Aeon\Collection;

use Aeon\Calendar\Gregorian\Day;

/**
 * @psalm-immutable
 */
final class DayValue
{
    private Day $day;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct(Day $day, $value)
    {
        $this->day = $day;
        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function createEmpty(Day $day) : self
    {
        return new self($day, null);
    }

    public function day() : Day
    {
        return $this->day;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
