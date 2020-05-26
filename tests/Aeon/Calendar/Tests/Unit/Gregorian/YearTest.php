<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Year;
use PHPUnit\Framework\TestCase;

final class YearTest extends TestCase
{
    public function test_months() : void
    {
        $this->assertSame(1, Year::fromString('2020-01-01')->january()->number());
        $this->assertSame(2, Year::fromString('2020-01-01')->february()->number());
        $this->assertSame(3, Year::fromString('2020-01-01')->march()->number());
        $this->assertSame(4, Year::fromString('2020-01-01')->april()->number());
        $this->assertSame(5, Year::fromString('2020-01-01')->may()->number());
        $this->assertSame(6, Year::fromString('2020-01-01')->june()->number());
        $this->assertSame(7, Year::fromString('2020-01-01')->july()->number());
        $this->assertSame(8, Year::fromString('2020-01-01')->august()->number());
        $this->assertSame(9, Year::fromString('2020-01-01')->september()->number());
        $this->assertSame(10, Year::fromString('2020-01-01')->october()->number());
        $this->assertSame(11, Year::fromString('2020-01-01')->november()->number());
        $this->assertSame(12, Year::fromString('2020-01-01')->december()->number());
    }

    /**
     * @dataProvider month_number_of_days_data_provider
     */
    public function test_month_number_of_days(int $year, int $month, int $numberOfDays) : void
    {
        $this->assertSame($numberOfDays, (new Year($year))->months()->byNumber($month)->numberOfDays());
    }

    /**
     * @return \Generator<int, array{int, int, int}, mixed, void>
     */
    public function month_number_of_days_data_provider() : \Generator
    {
        yield [2020, 1, 31];
        yield [2020, 2, 29];
        yield [2020, 3, 31];
        yield [2020, 4, 30];
        yield [2020, 5, 31];
        yield [2020, 6, 30];
        yield [2020, 7, 31];
        yield [2020, 8, 31];
        yield [2020, 9, 30];
        yield [2020, 10, 31];
        yield [2020, 11, 30];
        yield [2020, 12, 31];
        yield [2021, 1, 31];
        yield [2021, 2, 28];
    }

    public function test_map_days() : void
    {
        $this->assertCount(366, (new Year(2020))->mapDays(fn(Day $day) : int => $day->number()));
    }

    public function test_filter_days() : void
    {
        $this->assertSame(52, \count((new Year(2020))->filterDays(fn(Day $day) : bool => $day->isWeekend())) / 2);
    }

    public function test_next_year() : void
    {
        $this->assertSame(2021, (new Year(2020))->next()->number());
    }

    public function test_previous_year() : void
    {
        $this->assertSame(2019, (new Year(2020))->previous()->number());
    }
}