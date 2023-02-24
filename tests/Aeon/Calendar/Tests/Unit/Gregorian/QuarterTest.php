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

        new Quarter(0, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-02'), Month::fromString('2020-03')));
    }

    public function test_number_above_range() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Quarter(5, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-02'), Month::fromString('2020-03')));
    }

    public function test_invalid_number_of_months() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Quarter(1, Months::fromArray(Month::fromString('2020-01')));
    }

    public function test_invalid_months_quarter_1() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Quarter(1, Months::fromArray(Month::fromString('2020-05'), Month::fromString('2020-02'), Month::fromString('2020-03')));
    }

    public function test_invalid_months_quarter_2() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Quarter(2, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-05'), Month::fromString('2020-06')));
    }

    public function test_invalid_months_quarter_3() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Quarter(3, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-08'), Month::fromString('2020-09')));
    }

    public function test_invalid_months_quarter_4() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Quarter(4, Months::fromArray(Month::fromString('2020-01'), Month::fromString('2020-11'), Month::fromString('2020-12')));
    }
}
