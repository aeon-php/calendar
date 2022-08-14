<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;

/**
 * @psalm-immutable
 */
final class Quarter
{
    private int $number;

    private Months $months;

    public function __construct(int $number, Months $months)
    {
        if ($number < 1 || $number > 4) {
            throw new InvalidArgumentException('Quarter number must be greater or equal 1 and less or equal than 4');
        }

        if (\count($months) !== 3) {
            throw new InvalidArgumentException('Quarter must have exactly 3 months');
        }

        switch ($number) {
            case 1:
                if ($months->map(fn (Month $month) => $month->number()) !== [1, 2, 3]) {
                    throw new InvalidArgumentException('Quarter 1 must must have Jan, Feb and Mar');
                }

                break;
            case 2:
                if ($months->map(fn (Month $month) => $month->number()) !== [4, 5, 6]) {
                    throw new InvalidArgumentException('Quarter 2 must must have Apr, May and Jun');
                }

                break;
            case 3:
                if ($months->map(fn (Month $month) => $month->number()) !== [7, 8, 9]) {
                    throw new InvalidArgumentException('Quarter 3 must must have Jul, Aug and Sep');
                }

                break;
            case 4:
                if ($months->map(fn (Month $month) => $month->number()) !== [10, 11, 12]) {
                    throw new InvalidArgumentException('Quarter 4 must must have Oct, Nov and Dec');
                }

                break;
        }

        $this->number = $number;
        $this->months = $months;
    }

    public function number() : int
    {
        return $this->number;
    }

    public function months() : Months
    {
        return $this->months;
    }
}
