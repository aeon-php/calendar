<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Months;
use Aeon\Calendar\Gregorian\Quarter;
use PHPUnit\Framework\TestCase;

final class QuarterTest extends TestCase
{
    public function test_number_below_range() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Quarter number must be greater or equal 1 and less or equal than 4');

        new Quarter(0, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-02'), Month::fromString('2020-03')));
    }

    public function test_number_above_range() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Quarter number must be greater or equal 1 and less or equal than 4');

        new Quarter(5, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-02'), Month::fromString('2020-03')));
    }

    public function test_invalid_number_of_months() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Quarter must have exactly 3 months');

        new Quarter(1, Months::fromArray(Month::fromString('2020-01')));
    }

    public function test_invalid_months_quarter_1() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Quarter 1 must must have Jan, Feb and Mar');

        new Quarter(1, Months::fromArray(Month::fromString('2020-05'), Month::fromString('2020-02'), Month::fromString('2020-03')));
    }

    public function test_invalid_months_quarter_2() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Quarter 2 must must have Apr, May and Jun');

        new Quarter(2, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-05'), Month::fromString('2020-06')));
    }

    public function test_invalid_months_quarter_3() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Quarter 3 must must have Jul, Aug and Sep');

        new Quarter(3, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-08'), Month::fromString('2020-09')));
    }

    public function test_invalid_months_quarter_4() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessage('Quarter 4 must must have Oct, Nov and Dec');

        new Quarter(4, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-11'), Month::fromString('2020-12')));
    }
}
