<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\Interval;
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

    public function test_create_from_datetime() : void
    {
        $month = Month::fromDateTime(new \DateTimeImmutable('2020-02-01'));

        $this->assertSame(2, $month->number());
    }

    /**
     * @dataProvider creating_month_data_provider_from_string
     */
    public function test_creating_month_from_string(string $dateTimeString, string $dateTime) : void
    {
        try {
            $this->assertSame($dateTimeString, Month::fromString($dateTime)->toString());
        } catch (InvalidArgumentException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return \Generator<int, array{string, string}, mixed, void>
     */
    public function creating_month_data_provider_from_string() : \Generator
    {
        yield [(new \DateTimeImmutable('now'))->format('Y-m'), 'now'];
        yield [(new \DateTimeImmutable('now'))->format('Y-m'), 'NoW'];
        yield [(new \DateTimeImmutable('today'))->format('Y-m'), 'today'];
        yield [(new \DateTimeImmutable('today'))->format('Y-m'), 'today '];
        yield [(new \DateTimeImmutable('noon'))->format('Y-m'), 'noon'];
        yield [(new \DateTimeImmutable('noon'))->format('Y-m'), ' noon'];
        yield [(new \DateTimeImmutable('yesterday noon'))->format('Y-m'), 'yesterday noon'];
        yield [(new \DateTimeImmutable('tomorrow'))->format('Y-m'), 'tomorrow'];
        yield [(new \DateTimeImmutable('tomorrow midnight'))->format('Y-m'), 'tomorrow midnight'];
        yield [(new \DateTimeImmutable('yesterday'))->format('Y-m'), 'yesterday'];
        yield [(new \DateTimeImmutable('midnight'))->format('Y-m'), 'midnight'];
        yield [(new \DateTimeImmutable('24 week'))->format('Y-m'), '24 week'];
        yield [(new \DateTimeImmutable('today +1 hour'))->format('Y-m'), 'today +1 hour'];
        yield [(new \DateTimeImmutable('tomorrow +1 hour'))->format('Y-m'), 'tomorrow +1 hour'];
        yield [(new \DateTimeImmutable('-2 days'))->format('Y-m'), '-2 days'];
        yield [(new \DateTimeImmutable('Monday'))->format('Y-m'), 'Monday'];
        yield [(new \DateTimeImmutable('Monday next week'))->format('Y-m'), 'Monday next week'];
        yield [(new \DateTimeImmutable('next year'))->format('Y-m'), 'next year'];
        yield [(new \DateTimeImmutable('fifth day'))->format('Y-m'), 'fifth day'];
        yield [(new \DateTimeImmutable('first day of January 2019'))->format('Y-m'), 'first day of January 2019'];
    }

    /**
     * @dataProvider invalid_string_day_format
     */
    public function test_from_invalid_string(string $invalidValue) : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value \"{$invalidValue}\" is not valid month format.");

        Month::fromString($invalidValue);
    }

    /**
     * @return \Generator<int, array{string}, mixed, void>
     */
    public function invalid_string_day_format() : \Generator
    {
        yield ['test'];
    }

    /**
     * @dataProvider valid_string_day_format
     */
    public function test_from_string(string $invalidValue, Month $month) : void
    {
        $this->assertObjectEquals($month, Month::fromString($invalidValue), 'isEqual');
    }

    /**
     * @return \Generator<int, array{string, Time}, mixed, void>
     */
    public function valid_string_day_format() : \Generator
    {
        yield ['2020-01', new Month(new Year(2020), 1)];
        yield ['2020-01 +1 month', new Month(new Year(2020), 2)];
        yield ['2020-01 +1 year', new Month(new Year(2021), 1)];
        yield ['2020-01-01', new Month(new Year(2020), 1)];
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

    public function test_to_string() : void
    {
        $this->assertSame(
            '2020-01',
            Month::fromString('2020-01-01')->toString()
        );

        $this->assertSame(
            '2020-01',
            (string) Month::fromString('2020-01-01')
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
        $this->assertTrue(Month::fromString('2020-01-01')->isEqualTo(Month::fromString('2020-01-01')));
        $this->assertFalse(Month::fromString('2020-01-02')->isEqualTo(Month::fromString('2020-02-01')));
    }

    public function test_is_before() : void
    {
        $this->assertTrue(Month::fromString('2019-01-01')->isBefore(Month::fromString('2020-01-01')));
        $this->assertTrue(Month::fromString('2020-01-01')->isBeforeOrEqualTo(Month::fromString('2020-01-01')));

        $this->assertFalse(Month::fromString('2021-01-01')->isBefore(Month::fromString('2020-01-01')));
        $this->assertFalse(Month::fromString('2021-01-01')->isBeforeOrEqualTo(Month::fromString('2020-01-01')));

        $this->assertTrue(Month::fromString('2019-01-01')->isBeforeOrEqualTo(Month::fromString('2020-01-01')));
        $this->assertTrue(Month::fromString('2021-01-01')->isAfterOrEqualTo(Month::fromString('2020-01-01')));
    }

    public function test_is_after() : void
    {
        $this->assertTrue(Month::fromString('2022-01-01')->isAfter(Month::fromString('2020-02-01')));
        $this->assertTrue(Month::fromString('2020-01-01')->isAfterOrEqualTo(Month::fromString('2020-01-01')));

        $this->assertFalse(Month::fromString('2019-01-01')->isAfter(Month::fromString('2020-02-01')));
        $this->assertFalse(Month::fromString('2019-01-01')->isAfterOrEqualTo(Month::fromString('2020-02-01')));
    }

    public function test_until_with_wrong_destination_month() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('January 2020 is after January 2019');
        Month::fromString('2020-01-01')->until(Month::fromString('2019-01-01'), Interval::rightOpen());
    }

    public function test_since_with_wrong_destination_month() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('January 2019 is before January 2020');
        Month::fromString('2019-01-01')->since(Month::fromString('2020-01-01'), Interval::leftOpen());
    }

    public function test_until() : void
    {
        $this->assertCount(12, $months = Month::fromString('2020-01-01')->until(Month::fromString('2021-01-01'), Interval::rightOpen()));
        $this->assertInstanceOf(Month::class, $months->all()[0]);
        $this->assertInstanceOf(Month::class, $months->all()[11]);
        $this->assertSame('January', $months->all()[0]->name());
        $this->assertSame('December', $months->all()[11]->name());
    }

    public function test_since() : void
    {
        $this->assertCount(12, $months = Month::fromString('2022-01-01')->since(Month::fromString('2021-01-01'), Interval::leftOpen()));
        $this->assertInstanceOf(Month::class, $months->all()[0]);
        $this->assertInstanceOf(Month::class, $months->all()[11]);

        $this->assertSame('February', $months->all()[0]->name());
        $this->assertSame('January', $months->all()[11]->name());
    }

    public function test_iterate_until() : void
    {
        $this->assertCount(12, $months = Month::fromString('2020-01-01')->iterate(Month::fromString('2021-01-01'), Interval::rightOpen()));
        $this->assertInstanceOf(Month::class, $months->all()[0]);
        $this->assertInstanceOf(Month::class, $months->all()[11]);
        $this->assertSame('January', $months->all()[0]->name());
        $this->assertSame('December', $months->all()[11]->name());
    }

    public function test_iterate_since() : void
    {
        $this->assertCount(12, $months = Month::fromString('2022-01-01')->iterate(Month::fromString('2021-01-01'), Interval::leftOpen()));
        $this->assertInstanceOf(Month::class, $months->all()[0]);
        $this->assertInstanceOf(Month::class, $months->all()[11]);

        $this->assertSame('February', $months->all()[0]->name());
        $this->assertSame('January', $months->all()[11]->name());
    }

    public function test_modify_months() : void
    {
        $this->assertSame('2020-01-01', Month::fromString('2020-06-01')->subMonths(5)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-05-01', Month::fromString('2020-06-01')->subMonths(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-12-01', Month::fromString('2020-01-01')->subMonths(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2021-12-01', Month::fromString('2020-01-01')->addMonths(23)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-12-01', Month::fromString('2020-06-01')->addMonths(6)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2021-10-01', Month::fromString('2020-06-01')->addMonths(16)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2021-07-01', Month::fromString('2020-06-01')->addMonths(13)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2021-12-01', Month::fromString('2020-06-01')->addMonths(18)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2022-01-01', Month::fromString('2020-06-01')->addMonths(19)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2022-07-01', Month::fromString('2020-12-01')->addMonths(19)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2026-08-01', Month::fromString('2020-12-01')->addMonths(68)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-12-01', Month::fromString('2020-08-01')->addMonths(4)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('2019-12-01', Month::fromString('2020-06-01')->subMonths(6)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-02-01', Month::fromString('2020-06-01')->subMonths(16)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-05-01', Month::fromString('2020-06-01')->subMonths(13)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2018-12-01', Month::fromString('2020-06-01')->subMonths(18)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2018-11-01', Month::fromString('2020-06-01')->subMonths(19)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-05-01', Month::fromString('2020-12-01')->subMonths(19)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2015-04-01', Month::fromString('2020-12-01')->subMonths(68)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2020-04-01', Month::fromString('2020-08-01')->subMonths(4)->toDateTimeImmutable()->format('Y-m-d'));

        $this->assertSame('2015-06-01', Month::fromString('2020-06-01')->subYears(5)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-06-01', Month::fromString('2020-06-01')->subYears(1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2026-06-01', Month::fromString('2020-06-01')->addYears(6)->toDateTimeImmutable()->format('Y-m-d'));

        $this->asserTsame('2021-02-01', Month::fromString('2020-01-01')->add(1, 1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2019-12-01', Month::fromString('2020-01-01')->add(-1, -1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2018-12-01', Month::fromString('2020-01-01')->sub(1, 1)->toDateTimeImmutable()->format('Y-m-d'));
        $this->assertSame('2021-02-01', Month::fromString('2020-01-01')->sub(-1, -1)->toDateTimeImmutable()->format('Y-m-d'));
    }

    public function test_day_static_create() : void
    {
        $month = Month::create(2020, 12);
        $this->assertTrue(Month::fromString('2020-12-24')->isEqualTo($month));
    }

    public function test_distance_to() : void
    {
        $this->assertSame(31, Month::create(2020, 01)->distance(Month::create(2020, 02))->inDays());
    }

    public function test_quarter() : void
    {
        $this->assertSame(1, Month::fromString('2020-01-01')->quarter()->number());
        $this->assertSame(2, Month::fromString('2020-04-01')->quarter()->number());
        $this->assertSame(3, Month::fromString('2020-07-01')->quarter()->number());
        $this->assertSame(4, Month::fromString('2020-10-01')->quarter()->number());
    }

    public function test_serialization() : void
    {
        $month = Month::create(2020, 1);

        $this->assertObjectEquals(
            $month,
            \unserialize(\serialize($month)),
            'isEqual'
        );
    }

    public function test_number_of_days() : void
    {
        $this->assertSame(31, (new Month(new Year(2020), 1))->numberOfDays());
        $this->assertSame(29, (new Month(new Year(2020), 2))->numberOfDays());
        $this->assertSame(31, (new Month(new Year(2020), 3))->numberOfDays());
        $this->assertSame(30, (new Month(new Year(2020), 4))->numberOfDays());
        $this->assertSame(31, (new Month(new Year(2020), 5))->numberOfDays());
        $this->assertSame(30, (new Month(new Year(2020), 6))->numberOfDays());
        $this->assertSame(31, (new Month(new Year(2020), 7))->numberOfDays());
        $this->assertSame(31, (new Month(new Year(2020), 8))->numberOfDays());
        $this->assertSame(30, (new Month(new Year(2020), 9))->numberOfDays());
        $this->assertSame(31, (new Month(new Year(2020), 10))->numberOfDays());
        $this->assertSame(30, (new Month(new Year(2020), 11))->numberOfDays());
        $this->assertSame(31, (new Month(new Year(2020), 12))->numberOfDays());

        $this->assertSame(28, (new Month(new Year(2021), 2))->numberOfDays());
    }

    /**
     * @dataProvider compare_to_provider
     */
    public function test_compare_to(Month $time, Month $comparable, int $compareResult) : void
    {
        $this->assertSame($compareResult, $time->compareTo($comparable));
    }

    /**
     * @return \Generator<int, array{Month, Month, int}>
     */
    public function compare_to_provider() : \Generator
    {
        yield [Month::fromString('2022-10'), Month::fromString('2022-10'), 0];
        yield [Month::fromString('2022'), Month::fromString('2022'), 0];

        yield [Month::fromString('2022-09'), Month::fromString('2022-10'), -1];
        yield [Month::fromString('2021-10'), Month::fromString('2022-10'), -1];

        yield [Month::fromString('2022-11'), Month::fromString('2022-10'), 1];
        yield [Month::fromString('2022-10'), Month::fromString('2021-10'), 1];
    }
}
