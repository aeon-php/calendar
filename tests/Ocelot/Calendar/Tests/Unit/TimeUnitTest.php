<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit;

use Ocelot\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimeUnitTest extends TestCase
{
    public function test_time_unit_create_from_days() : void
    {
        $unit = TimeUnit::days(5);

        $this->assertSame(5, $unit->inDays());
        $this->assertSame(120, $unit->inHours());
        $this->assertSame(7200, $unit->inMinutes());
        $this->assertSame(432000, $unit->inSeconds());
    }

    public function test_time_unit_create_from_hours() : void
    {
        $unit = TimeUnit::hours(2);

        $this->assertSame(0, $unit->inDays());
        $this->assertSame(2, $unit->inHours());
        $this->assertSame(120, $unit->inMinutes());
        $this->assertSame(7200, $unit->inSeconds());
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
        $this->assertSame(8, TimeUnit::seconds(68)->inTimeSeconds());
        $this->assertSame(8, TimeUnit::minutes(68)->inTimeMinutes());
        $this->assertSame(15, TimeUnit::minutes(135)->inTimeMinutes());
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
        $this->assertSame(0.500000, TimeUnit::precise(0.5)->inSecondsPrecise());
        $this->assertSame("0.500000", TimeUnit::precise(0.5)->inSecondsPreciseString());
    }

    public function test_creating_negative_precise_timeunit() : void
    {
        $this->assertSame(500000, TimeUnit::precise(-0.5)->microsecond());
        $this->assertSame(0, TimeUnit::precise(-0.5)->inSeconds());
        $this->assertSame(500, TimeUnit::precise(-0.5)->inMilliseconds());
        $this->assertTrue(TimeUnit::precise(-0.5)->isNegative());
        $this->assertSame(-0.500000, TimeUnit::precise(-0.5)->inSecondsPrecise());
        $this->assertSame("-0.500000", TimeUnit::precise(-0.5)->inSecondsPreciseString());
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
            TimeUnit::precise($seconds)->add(TimeUnit::precise($addedSeconds))->inSecondsPreciseString()
        );
    }

    /**
     * @return \Generator<int, array{int, int, string, float, float}, mixed, void>
     */
    public function adding_precise_time_test_data_provider() : \Generator
    {
        yield [0, 0, "0.000000", 0.0, 0.0];
        yield [0, 500001, "0.500001", 0.0, 0.500001];
        yield [0, 10001, "0.010001", 0.0, 0.010001];
        yield [0, 0, "0.000000", -0.500000, 0.500000];
        yield [0, 0, "0.000000", -0.500000, 0.5000001]; // 7+ decimal points are ignored
        yield [-1, 300000, "-1.300000", -1.500000, 0.200000];
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
            TimeUnit::precise($seconds)->sub(TimeUnit::precise($addedSeconds))->inSecondsPreciseString()
        );
    }

    /**
     * @return \Generator<int, array{int, int, string, float, float}, mixed, void>
     */
    public function subtracting_precise_time_test_data_provider() : \Generator
    {
        yield [0, 0, "0.000000", 0.0, 0.0];
        yield [0, 500000, "-0.500000", 0.0, 0.500000];
        yield [0, 50000, "-0.050000", 0.0, 0.050000];
    }
}