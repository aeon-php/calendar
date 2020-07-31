<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Year;
use PHPUnit\Framework\TestCase;

final class MonthTest extends TestCase
{
    public function test_create_with_month_number_lower_than_0() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Month(new Year(2020), 0);
    }

    public function test_create_with_month_number_greater_than_12() : void
    {
        $this->expectException(InvalidArgumentException::class);

        new Month(new Year(2020), 13);
    }

    public function test_first_day_of_month() : void
    {
        $month = Month::fromString('2020-01-01');

        $this->assertSame(1, $month->firstDay()->number());
    }

    public function test_create_from_datetime_() : void
    {
        $month = Month::fromDateTime(new \DateTimeImmutable('2020-02-01'));

        $this->assertSame(2, $month->number());
    }

    public function test_debug_info() : void
    {
        $this->assertSame(
            [
                'year' => 2020,
                'month' => 1,
            ],
            Month::fromString('2020-01-01')->__debugInfo()
        );
    }

    public function test_last_day_of_month() : void
    {
        $month = Month::fromString('2020-01-01');

        $this->assertSame(31, $month->lastDay()->number());
    }

    public function test_next_month() : void
    {
        $this->assertSame(2, Month::fromString('2020-01-01')->next()->number());
    }

    public function test_previous_month() : void
    {
        $this->assertSame(1, Month::fromString('2020-02-01')->previous()->number());
    }

    public function test_name() : void
    {
        $this->assertSame('January', Month::fromString('2020-01-01')->name());
    }

    public function test_short_name() : void
    {
        $this->assertSame('Jan', Month::fromString('2020-01-01')->shortName());
    }

    public function test_reset_time_in_to_datetime_immutable() : void
    {
        $month = new Month(new Year(2020), 1);

        $dateTimeImmutable1 = $month->toDateTimeImmutable();
        \sleep(1);
        $dateTimeImmutable2 = $month->toDateTimeImmutable();

        $this->assertTrue($dateTimeImmutable1 == $dateTimeImmutable2);
    }

    public function test_is_equal() : void
    {
        $this->assertTrue(Month::fromString('2020-01-01')->isEqual(Month::fromString('2020-01-01')));
        $this->assertFalse(Month::fromString('2020-01-02')->isEqual(Month::fromString('2020-02-01')));
    }

    public function test_is_before() : void
    {
        $this->assertTrue(Month::fromString('2019-01-01')->isBefore(Month::fromString('2020-01-01')));
        $this->assertTrue(Month::fromString('2020-01-01')->isBeforeOrEqual(Month::fromString('2020-01-01')));

        $this->assertFalse(Month::fromString('2021-01-01')->isBefore(Month::fromString('2020-01-01')));
        $this->assertFalse(Month::fromString('2021-01-01')->isBeforeOrEqual(Month::fromString('2020-01-01')));

        $this->assertTrue(Month::fromString('2019-01-01')->isBeforeOrEqual(Month::fromString('2020-01-01')));
        $this->assertTrue(Month::fromString('2021-01-01')->isAfterOrEqual(Month::fromString('2020-01-01')));
    }

    public function test_is_after() : void
    {
        $this->assertTrue(Month::fromString('2022-01-01')->isAfter(Month::fromString('2020-02-01')));
        $this->assertTrue(Month::fromString('2020-01-01')->isAfterOrEqual(Month::fromString('2020-01-01')));

        $this->assertFalse(Month::fromString('2019-01-01')->isAfter(Month::fromString('2020-02-01')));
        $this->assertFalse(Month::fromString('2019-01-01')->isAfterOrEqual(Month::fromString('2020-02-01')));
    }

    public function test_until_with_wrong_destination_month() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('January 2020 is after January 2019');
        Month::fromString('2020-01-01')->until(Month::fromString('2019-01-01'));
    }

    public function test_since_with_wrong_destination_month() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('January 2019 is before January 2020');
        Month::fromString('2019-01-01')->since(Month::fromString('2020-01-01'));
    }

    public function test_until() : void
    {
        $this->assertCount(12, $months = Month::fromString('2020-01-01')->until(Month::fromString('2021-01-01')));
        $this->assertInstanceOf(Month::class, $months[0]);
        $this->assertInstanceOf(Month::class, $months[11]);
        $this->assertSame('January', $months[0]->name());
        $this->assertSame('December', $months[11]->name());
    }

    public function test_since() : void
    {
        $this->assertCount(12, $months = Month::fromString('2022-01-01')->since(Month::fromString('2021-01-01')));
        $this->assertInstanceOf(Month::class, $months[0]);
        $this->assertInstanceOf(Month::class, $months[11]);
        $this->assertSame('January', $months[11]->name());
        $this->assertSame('December', $months[0]->name());
    }

    public function test_iterate_until() : void
    {
        $this->assertCount(12, $months = Month::fromString('2020-01-01')->iterate(Month::fromString('2021-01-01')));
        $this->assertInstanceOf(Month::class, $months[0]);
        $this->assertInstanceOf(Month::class, $months[11]);
        $this->assertSame('January', $months[0]->name());
        $this->assertSame('December', $months[11]->name());
    }

    public function test_iterate_since() : void
    {
        $this->assertCount(12, $months = Month::fromString('2022-01-01')->iterate(Month::fromString('2021-01-01')));
        $this->assertInstanceOf(Month::class, $months[0]);
        $this->assertInstanceOf(Month::class, $months[11]);
        $this->assertSame('January', $months[11]->name());
        $this->assertSame('December', $months[0]->name());
    }

    public function test_modify_months() : void
    {
        $this->assertSame('2020-01-01', Month::fromString('2020-06-01')->minusMonths(5)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-05-01', Month::fromString('2020-06-01')->minusMonths(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-12-01', Month::fromString('2020-06-01')->plusMonths(6)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('2015-06-01', Month::fromString('2020-06-01')->minusYears(5)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-06-01', Month::fromString('2020-06-01')->minusYears(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2026-06-01', Month::fromString('2020-06-01')->plusYears(6)->toDateTimeImmutable()->format('Y-m-d'));

        $this->asserTsame('2021-02-01', Month::fromString('2020-01-01')->plus(1, 1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->asserTsame('2018-12-01', Month::fromString('2020-01-01')->minus(1, 1)->toDateTimeImmutable()->format('Y-m-d'));
    }

    public function test_day_static_create() : void
    {
        $month = Month::create(2020, 12);
        $this->assertTrue(Month::fromString('2020-12-24')->isEqual($month));
    }
}
