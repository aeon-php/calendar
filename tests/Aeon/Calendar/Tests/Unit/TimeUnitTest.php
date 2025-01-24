<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimeUnitTest extends TestCase
{
    public function test_invert() : void
    {
        $timeUnit = TimeUnit::day()->invert();

        $this->assertSame(-86400, $timeUnit->inSeconds());
    }

    public function test_creating_with_negative_seconds() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Seconds must be greater or equal 0, got -1');

        TimeUnit::negative(-1, 0);
    }

    public function test_creating_with_negative_microsecond() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Microsecond must be greater or equal 0 and less than 1000000, got -5');

        TimeUnit::negative(0, -5);
    }

    public function test_creating_with_invalid_microsecond() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Microsecond must be greater or equal 0 and less than 1000000, got 1000000');

        TimeUnit::negative(0, 1_000_000);
    }

    public function test_time_unit_create_from_day() : void
    {
        $unit = TimeUnit::day();

        $this->assertSame(1, $unit->inDays());
    }

    public function test_time_unit_create_from_days() : void
    {
        $unit = TimeUnit::days(5);

        $this->assertSame(5, $unit->inDays());
        $this->assertSame(120, $unit->inHours());
        $this->assertSame(7200, $unit->inMinutes());
        $this->assertSame(432000, $unit->inSeconds());
        $this->assertSame('432000.000000', $unit->inSecondsPrecise());
        $this->assertSame(432000000, $unit->inMilliseconds());
        $this->assertSame(432000, $unit->toDateInterval()->s);
    }

    public function test_time_unit_create_from_days_negative() : void
    {
        $unit = TimeUnit::days(-5);

        $this->assertSame(5, $unit->inDaysAbs());
        $this->assertSame(-5, $unit->inDays());
        $this->assertSame(-120, $unit->inHours());
        $this->assertSame(120, $unit->inHoursAbs());
        $this->assertSame(-7200, $unit->inMinutes());
        $this->assertSame(7200, $unit->inMinutesAbs());
        $this->assertSame(-432000, $unit->inSeconds());
        $this->assertSame(432000, $unit->inSecondsAbs());
        $this->assertSame('-432000.000000', $unit->inSecondsPrecise());
        $this->assertSame(-432000000, $unit->inMilliseconds());
        $this->assertSame(432000000, $unit->inMillisecondsAbs());
        $this->assertSame(432000, $unit->toDateInterval()->s);
        $this->assertSame(1, $unit->toDateInterval()->invert);
    }

    public function test_time_unit_create_with_value_1() : void
    {
        $this->assertSame(1000, TimeUnit::millisecond()->microsecond());
        $this->assertSame(0, TimeUnit::second()->microsecond());
        $this->assertSame(0, TimeUnit::minute()->microsecond());
        $this->assertSame(0, TimeUnit::hour()->microsecond());
        $this->assertSame(0, TimeUnit::day()->microsecond());
    }

    public function test_time_unit_create_with_0_value() : void
    {
        $this->assertTrue(TimeUnit::milliseconds(0)->isPositive());
        $this->assertTrue(TimeUnit::seconds(0)->isPositive());
        $this->assertTrue(TimeUnit::minutes(0)->isPositive());
        $this->assertTrue(TimeUnit::hours(0)->isPositive());
        $this->assertTrue(TimeUnit::days(0)->isPositive());
    }

    public function test_time_unit_create_from_hours() : void
    {
        $unit = TimeUnit::hours(2);

        $this->assertSame(0, $unit->inDays());
        $this->assertSame(2, $unit->inHours());
        $this->assertSame(120, $unit->inMinutes());
        $this->assertSame(7200, $unit->inSeconds());
    }

    public function test_time_unit_create_from_minute() : void
    {
        $unit = TimeUnit::minute();

        $this->assertSame(1, $unit->inMinutes());
    }

    public function test_time_unit_create_from_0_minutes() : void
    {
        $unit = TimeUnit::minutes(0);

        $this->assertTrue($unit->isPositive());
    }

    public function test_time_unit_create_from_minutes() : void
    {
        $unit = TimeUnit::minutes(2);

        $this->assertSame(0, $unit->inDays());
        $this->assertSame(0, $unit->inHours());
        $this->assertSame(2, $unit->inMinutes());
        $this->assertSame(120, $unit->inSeconds());
    }

    public function test_in_time_values() : void
    {
        $this->assertSame(2, TimeUnit::hours(26)->inTimeHours());
        $this->assertSame(2, TimeUnit::hours(-26)->inTimeHours());
        $this->assertSame(8, TimeUnit::seconds(-68)->inTimeSeconds());
        $this->assertSame(8, TimeUnit::seconds(68)->inTimeSeconds());
        $this->assertSame(8, TimeUnit::minutes(-68)->inTimeMinutes());
        $this->assertSame(8, TimeUnit::minutes(68)->inTimeMinutes());
        $this->assertSame(15, TimeUnit::minutes(135)->inTimeMinutes());
        $this->assertSame(500, TimeUnit::milliseconds(1500)->inTimeMilliseconds());
        $this->assertSame(500, TimeUnit::milliseconds(-1500)->inTimeMilliseconds());
    }

    public function test_complex_time_unit_in_time_values() : void
    {
        $timeUnit = TimeUnit::days(3)
            ->add(TimeUnit::hours(4))
            ->add(TimeUnit::minutes(85))
            ->add(TimeUnit::seconds(30))
            ->add(TimeUnit::milliseconds(1480));

        $this->assertSame(5, $timeUnit->inTimeHours());
        $this->assertSame(25, $timeUnit->inTimeMinutes());
        $this->assertSame(31, $timeUnit->inTimeSeconds());
        $this->assertSame(480, $timeUnit->inTimeMilliseconds());
    }

    public function test_is_zero() : void
    {
        $this->assertFalse(TimeUnit::second()->isZero());
        $this->assertTrue(TimeUnit::seconds(0)->isZero());
    }

    public function test_second() : void
    {
        $timeUnit = TimeUnit::second();

        $this->assertSame(1, $timeUnit->inSeconds());
    }

    public function test_millisecond() : void
    {
        $timeUnit = TimeUnit::millisecond();

        $this->assertSame(1000, $timeUnit->microsecond());
        $this->assertSame(1, $timeUnit->inMilliseconds());
    }

    public function test_milliseconds() : void
    {
        $timeUnit = TimeUnit::milliseconds(1500);

        $this->assertSame(500000, $timeUnit->microsecond());
        $this->assertSame(1, $timeUnit->inSeconds());
        $this->assertsame(1500, $timeUnit->inMilliseconds());
    }

    public function test_creating_precise_timeunit() : void
    {
        $this->assertSame(500000, TimeUnit::precise(0.5)->microsecond());
        $this->assertSame(0, TimeUnit::precise(0.5)->inSeconds());
        $this->assertSame(500, TimeUnit::precise(0.5)->inMilliseconds());
        $this->assertFalse(TimeUnit::precise(0.5)->isNegative());
        $this->assertSame('0.500000', TimeUnit::precise(0.5)->inSecondsPrecise());
    }

    public function test_creating_negative_precise_timeunit() : void
    {
        $this->assertSame(500000, TimeUnit::precise(-0.5)->microsecond());
        $this->assertSame(0, TimeUnit::precise(-0.5)->inSeconds());
        $this->assertSame(-500, TimeUnit::precise(-0.5)->inMilliseconds());
        $this->assertTrue(TimeUnit::precise(-0.5)->isNegative());
        $this->assertSame('-0.500000', TimeUnit::precise(-0.5)->inSecondsPrecise());
    }

    /**
     * @dataProvider greater_than_data_provider
     */
    public function test_greater_than(TimeUnit $timeUnit, TimeUnit $nextTimeUnit, bool $expectedResult) : void
    {
        $this->assertSame($expectedResult, $timeUnit->isGreaterThan($nextTimeUnit));
    }

    /**
     * @return \Generator<int, array{TimeUnit, TimeUnit, bool}, mixed, void>
     */
    public function greater_than_data_provider() : \Generator
    {
        yield [TimeUnit::seconds(1), TimeUnit::seconds(-5), true];
        yield [TimeUnit::seconds(1), TimeUnit::seconds(5), false];
        yield [TimeUnit::seconds(5), TimeUnit::seconds(5), false];
        yield [TimeUnit::seconds(10), TimeUnit::seconds(5), true];
        yield [TimeUnit::precise(0.000001), TimeUnit::precise(0.000000), true];
        yield [TimeUnit::precise(0.000010), TimeUnit::precise(0.000000), true];
        yield [TimeUnit::precise(0.000001), TimeUnit::precise(0.000010), false];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000000), false];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000001), false];
    }

    /**
     * @dataProvider greater_than_eq_data_provider
     */
    public function test_greater_than_eq(TimeUnit $timeUnit, TimeUnit $nextTimeUnit, bool $expectedResult) : void
    {
        $this->assertSame($expectedResult, $timeUnit->isGreaterThanOrEqualTo($nextTimeUnit));
    }

    /**
     * @return \Generator<int, array{TimeUnit, TimeUnit, bool}, mixed, void>
     */
    public function greater_than_eq_data_provider() : \Generator
    {
        yield [TimeUnit::seconds(1), TimeUnit::seconds(-5), true];
        yield [TimeUnit::seconds(1), TimeUnit::seconds(5), false];
        yield [TimeUnit::seconds(5), TimeUnit::seconds(5), true];
        yield [TimeUnit::seconds(10), TimeUnit::seconds(5), true];
        yield [TimeUnit::precise(0.000001), TimeUnit::precise(0.000000), true];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000000), true];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000001), false];
    }

    /**
     * @dataProvider less_than_data_provider
     */
    public function test_less_than(TimeUnit $timeUnit, TimeUnit $nextTimeUnit, bool $expectedResult) : void
    {
        $this->assertSame($expectedResult, $timeUnit->isLessThan($nextTimeUnit));
    }

    /**
     * @return \Generator<int, array{TimeUnit, TimeUnit, bool}, mixed, void>
     */
    public function less_than_data_provider() : \Generator
    {
        yield [TimeUnit::seconds(1), TimeUnit::seconds(-5), false];
        yield [TimeUnit::seconds(1), TimeUnit::seconds(5), true];
        yield [TimeUnit::seconds(5), TimeUnit::seconds(5), false];
        yield [TimeUnit::seconds(10), TimeUnit::seconds(5), false];
        yield [TimeUnit::precise(0.000001), TimeUnit::precise(0.000000), false];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000000), false];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000001), true];
    }

    /**
     * @dataProvider less_than_eq_data_provider
     */
    public function test_less_than_eq(TimeUnit $timeUnit, TimeUnit $nextTimeUnit, bool $expectedResult) : void
    {
        $this->assertSame($expectedResult, $timeUnit->isLessThanOrEqualTo($nextTimeUnit));
    }

    /**
     * @return \Generator<int, array{TimeUnit, TimeUnit, bool}, mixed, void>
     */
    public function less_than_eq_data_provider() : \Generator
    {
        yield [TimeUnit::seconds(1), TimeUnit::seconds(-5), false];
        yield [TimeUnit::seconds(1), TimeUnit::seconds(5), true];
        yield [TimeUnit::seconds(5), TimeUnit::seconds(5), true];
        yield [TimeUnit::seconds(10), TimeUnit::seconds(5), false];
        yield [TimeUnit::precise(0.000001), TimeUnit::precise(0.000000), false];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000000), true];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000001), true];
    }

    /**
     * @dataProvider equal_data_provider
     */
    public function test_equal(TimeUnit $timeUnit, TimeUnit $nextTimeUnit, bool $expectedResult) : void
    {
        $this->assertSame($expectedResult, $timeUnit->isEqualTo($nextTimeUnit));
    }

    /**
     * @return \Generator<int, array{TimeUnit, TimeUnit, bool}, mixed, void>
     */
    public function equal_data_provider() : \Generator
    {
        yield [TimeUnit::seconds(1), TimeUnit::seconds(-5), false];
        yield [TimeUnit::seconds(1), TimeUnit::seconds(5), false];
        yield [TimeUnit::seconds(5), TimeUnit::seconds(5), true];
        yield [TimeUnit::seconds(10), TimeUnit::seconds(5), false];
        yield [TimeUnit::precise(0.000001), TimeUnit::precise(0.000000), false];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000000), true];
        yield [TimeUnit::precise(0.000000), TimeUnit::precise(0.000001), false];
    }

    /**
     * @dataProvider adding_time_test_data_provider
     */
    public function test_adding_time_units(int $seconds, int $addedSeconds, int $expectedSeconds) : void
    {
        $this->assertSame($expectedSeconds, TimeUnit::seconds($seconds)->add(TimeUnit::seconds($addedSeconds))->inSeconds());
    }

    /**
     * @return \Generator<int, array{int, int, int}, mixed, void>
     */
    public function adding_time_test_data_provider() : \Generator
    {
        yield [5, 5, 10];
        yield [-20, 10, -10];
        yield [-5, 10, 5];
    }

    /**
     * @dataProvider subtracting_time_test_data_provider
     */
    public function test_subtracting_time_units(int $seconds, int $substractedSeconds, int $expectedSeconds) : void
    {
        $this->assertSame($expectedSeconds, TimeUnit::seconds($seconds)->sub(TimeUnit::seconds($substractedSeconds))->inSeconds());
    }

    /**
     * @return \Generator<int, array{int, int, int}, mixed, void>
     */
    public function subtracting_time_test_data_provider() : \Generator
    {
        yield [5, 5, 0];
        yield [5, 15, -10];
    }

    /**
     * @dataProvider adding_precise_time_test_data_provider
     */
    public function test_adding_precise_time_units(int $expectedSeconds, int $expectedMicrosecond, string $expectedPreciseString, float $seconds, float $addedSeconds) : void
    {
        $this->assertSame(
            $expectedSeconds,
            TimeUnit::precise($seconds)->add(TimeUnit::precise($addedSeconds))->inSeconds()
        );
        $this->assertSame(
            $expectedMicrosecond,
            TimeUnit::precise($seconds)->add(TimeUnit::precise($addedSeconds))->microsecond()
        );
        $this->assertSame(
            $expectedPreciseString,
            TimeUnit::precise($seconds)->add(TimeUnit::precise($addedSeconds))->inSecondsPrecise()
        );
    }

    /**
     * @return \Generator<int, array{int, int, string, float, float}, mixed, void>
     */
    public function adding_precise_time_test_data_provider() : \Generator
    {
        yield [0, 0, '0.000000', 0.0, 0.0];
        yield [0, 500001, '0.500001', 0.0, 0.500001];
        yield [0, 10001, '0.010001', 0.0, 0.010001];
        yield [0, 0, '0.000000', -0.500000, 0.500000];
        yield [0, 0, '0.000000', -0.500000, 0.5000001]; // 7+ decimal points are ignored
        yield [-1, 300000, '-1.300000', -1.500000, 0.200000];
    }

    /**
     * @dataProvider subtracting_precise_time_test_data_provider
     */
    public function test_subtracting_precise_time_units(int $expectedSeconds, int $expectedMicrseond, string $expectedPreciseString, float $seconds, float $addedSeconds) : void
    {
        $this->assertSame(
            $expectedSeconds,
            TimeUnit::precise($seconds)->sub(TimeUnit::precise($addedSeconds))->inSeconds()
        );
        $this->assertSame(
            $expectedMicrseond,
            TimeUnit::precise($seconds)->sub(TimeUnit::precise($addedSeconds))->microsecond()
        );
        $this->assertSame(
            $expectedPreciseString,
            TimeUnit::precise($seconds)->sub(TimeUnit::precise($addedSeconds))->inSecondsPrecise()
        );
    }

    /**
     * @return \Generator<int, array{int, int, string, float, float}, mixed, void>
     */
    public function subtracting_precise_time_test_data_provider() : \Generator
    {
        yield [0, 0, '0.000000', 0.0, 0.0];
        yield [0, 500000, '-0.500000', 0.0, 0.500000];
        yield [0, 50000, '-0.050000', 0.0, 0.050000];
        yield [2, 508825, '2.508825', 2.588460, 0.079635];
    }

    /**
     * @dataProvider creating_from_date_interval_provider
     */
    public function test_creating_from_date_interval(\DateInterval $dateInterval, TimeUnit $timeUnit) : void
    {
        $this->assertObjectEquals(TimeUnit::fromDateInterval($dateInterval), $timeUnit, 'isEqual');
    }

    /**
     * @return \Generator<int, array{\DateInterval, TimeUnit}, mixed, void>
     */
    public function creating_from_date_interval_provider() : \Generator
    {
        yield [\DateInterval::createFromDateString('5 microseconds'), TimeUnit::precise(0.000005)];
        yield [\DateInterval::createFromDateString('1 second 5 microseconds'), TimeUnit::precise(1.000005)];
        yield [\DateInterval::createFromDateString('1 second'), TimeUnit::second()];
        yield [\DateInterval::createFromDateString('5 seconds'), TimeUnit::seconds(5)];
        yield [\DateInterval::createFromDateString('1 minute'), TimeUnit::minute()];
        yield [\DateInterval::createFromDateString('5 minutes'), TimeUnit::minutes(5)];
        yield [\DateInterval::createFromDateString('1 hour'), TimeUnit::hour()];
        yield [\DateInterval::createFromDateString('10 hours'), TimeUnit::hours(10)];
        yield [\DateInterval::createFromDateString('28 hours'), TimeUnit::hours(28)];
        yield [\DateInterval::createFromDateString('1 day'), TimeUnit::day()];
        yield [\DateInterval::createFromDateString('365 days'), TimeUnit::days(365)];
        yield [(new \DateTimeImmutable('2020-01-01'))->diff(new \DateTimeImmutable('2019-01-01')), TimeUnit::days(365)->invert()];
        yield [(new \DateTimeImmutable('2020-01-01'))->diff(new \DateTimeImmutable('2020-03-01')), TimeUnit::days(60)];
    }

    /**
     * @dataProvider creating_from_date_string_provider
     */
    public function test_creating_from_date_string(string $dateString, TimeUnit $timeUnit) : void
    {
        $this->assertObjectEquals(TimeUnit::fromDateString($dateString), $timeUnit, 'isEqual');
    }

    /**
     * @return \Generator<int, array{string, TimeUnit}, mixed, void>
     */
    public function creating_from_date_string_provider() : \Generator
    {
        yield ['5 microseconds', TimeUnit::precise(0.000005)];
        yield ['1 second 5 microsecond', TimeUnit::precise(1.000005)];
        yield ['1 second', TimeUnit::second()];
        yield ['5 seconds', TimeUnit::seconds(5)];
        yield ['1 minute', TimeUnit::minute()];
        yield ['5 minutes', TimeUnit::minutes(5)];
        yield ['1 hour', TimeUnit::hour()];
        yield ['10 hours', TimeUnit::hours(10)];
        yield ['28 hours', TimeUnit::hours(28)];
        yield ['1 day', TimeUnit::day()];
        yield ['365 days', TimeUnit::days(365)];
    }

    public function test_creating_from_inaccurate_date_interval_years() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Can\'t convert P1Y0M0DT0H0M0S precisely to time unit because year can\'t be directly converted to number of seconds.');

        TimeUnit::fromDateInterval(\DateInterval::createFromDateString('1 year'));
    }

    public function test_creating_from_inaccurate_date_interval_months() : void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Can\'t convert P0Y4M0DT0H0M0S precisely to time unit because month can\'t be directly converted to number of seconds.');

        TimeUnit::fromDateInterval(\DateInterval::createFromDateString('4 months'));
    }

    /**
     * @dataProvider half_round_up_to_microsecond_data_provider
     */
    public function test_half_round_up_to_microsecond(string $stringFloat, float $float) : void
    {
        $this->assertSame(
            $stringFloat,
            TimeUnit::precise($float)->inSecondsPrecise(),
            $stringFloat . ' is not equal ' . $float
        );
    }

    /**
     * @return \Generator<int, array{string, float}, mixed, void>
     */
    public function half_round_up_to_microsecond_data_provider() : \Generator
    {
        yield ['0.000000', 0.000_000_1];
        yield ['0.000000', -0.000_000_1];
        yield ['0.000001', 0.000_000_5];
        yield ['-0.000001', -0.000_000_5];
        yield ['-0.000001', -0.000_000_94];
        yield ['0.000001', 0.000_000_99];
    }

    /**
     * @dataProvider multiplication_data_provider
     */
    public function test_multiplication(TimeUnit $timeUnit, TimeUnit $multiplier, TimeUnit $expectedResult) : void
    {
        $this->assertSame($expectedResult->inSecondsPrecise(), $timeUnit->multiply($multiplier)->inSecondsPrecise());
    }

    /**
     * @return \Generator<int, array{TimeUnit, float, TimeUnit}, mixed, void>
     */
    public function multiplication_data_provider() : \Generator
    {
        yield [TimeUnit::precise(1.00), TimeUnit::precise(2.00), TimeUnit::precise(2.00)];
        yield [TimeUnit::precise(1.00), TimeUnit::precise(0.50), TimeUnit::precise(0.50)];
        yield [TimeUnit::seconds(1), TimeUnit::precise(0.50), TimeUnit::milliseconds(500)];
    }

    /**
     * @dataProvider division_data_provider
     */
    public function test_division(TimeUnit $timeUnit, TimeUnit $multiplier, TimeUnit $expectedResult) : void
    {
        $this->assertSame($expectedResult->inSecondsPrecise(), $timeUnit->divide($multiplier)->inSecondsPrecise());
    }

    /**
     * @return \Generator<int, array{TimeUnit, float, TimeUnit}, mixed, void>
     */
    public function division_data_provider() : \Generator
    {
        yield [TimeUnit::precise(1.00), TimeUnit::precise(2.00), TimeUnit::milliseconds(500)];
        yield [TimeUnit::precise(10.00), TimeUnit::precise(10.00), TimeUnit::seconds(1)];
        yield [TimeUnit::hours(1), TimeUnit::precise(60.00), TimeUnit::minutes(1)];
    }

    /**
     * @dataProvider modulo_data_provider
     */
    public function test_modulo(TimeUnit $timeUnit, TimeUnit $multiplier, TimeUnit $expectedResult) : void
    {
        $this->assertSame($expectedResult->inSecondsPrecise(), $timeUnit->modulo($multiplier)->inSecondsPrecise());
    }

    /**
     * @return \Generator<int, array{TimeUnit, float, TimeUnit}, mixed, void>
     */
    public function modulo_data_provider() : \Generator
    {
        yield [TimeUnit::precise(1.00), TimeUnit::precise(2.00), TimeUnit::second()];
        yield [TimeUnit::precise(10.00), TimeUnit::precise(10.00), TimeUnit::seconds(0)];
        yield [TimeUnit::hours(1), TimeUnit::precise(60.00), TimeUnit::seconds(0)];
        yield [TimeUnit::hours(1), TimeUnit::minutes(37), TimeUnit::minutes(23)];
    }

    public function test_to_negative() : void
    {
        $this->assertTrue(TimeUnit::negative(10, 0)->toNegative()->isNegative());
        $this->assertTrue(TimeUnit::positive(10, 0)->toNegative()->isNegative());
    }

    public function test_to_positive() : void
    {
        $this->assertTrue(TimeUnit::positive(10, 0)->toPositive()->isPositive());
        $this->assertTrue(TimeUnit::negative(10, 0)->toPositive()->isPositive());
    }

    public function test_to_date_interval() : void
    {
        $interval = new \DateInterval('PT2S');
        $interval->f = 0.500000;

        $this->assertEquals($interval, TimeUnit::precise(2.500000)->toDateInterval());
    }

    public function test_getting_microsecond_string() : void
    {
        $this->assertSame('500000', TimeUnit::precise(2.500000)->microsecondString());
    }

    public function test_serialization() : void
    {
        $timeUnit = TimeUnit::positive(10, 10);

        $this->assertSame(
            [
                'seconds' => 10,
                'microsecond' => 10,
                'negative' => false,
            ],
            $timeUnit->__serialize()
        );
    }
}
