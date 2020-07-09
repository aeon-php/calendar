<?php

declare(strict_types=1);

namespace Aeon\Calculator\Tests\Unit;

use Aeon\Calculator\PHPCalculator;
use PHPStan\Testing\TestCase;

final class PHPCalculatorTest extends TestCase
{
    /**
     * @dataProvider is_equal_data_provider
     */
    public function test_is_equal(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isEqual((string) $value, (string) $nextValue));
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public function is_equal_data_provider() : \Generator
    {
        yield [false, 2.0, 1.0];
        yield [false, 2, 1];
        yield [true, 0.000_100, 0.000_100];
        yield [false, 0.000_101, 0.000_100];
        yield [true, 0.000_000, 0.000_000_1];
        yield [true, 0.000_000_49, 0.000_000_1];
    }

    /**
     * @dataProvider is_less_data_provider
     */
    public function test_is_less(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isLessThan((string) $value, (string) $nextValue));
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public function is_less_data_provider() : \Generator
    {
        yield [false, 2.0, 1.0];
        yield [false, 2, 1];
        yield [false, 0.000_000, 0.000_000_1];
        yield [false, 0.000_000_49, 0.000_000_1];
        yield [true, 0.000_000_1, 0.000_000_51];
    }

    /**
     * @dataProvider is_greater_data_provider
     */
    public function test_is_greater(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isGreaterThan((string) $value, (string) $nextValue));
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public function is_greater_data_provider() : \Generator
    {
        yield [true, 2.0, 1.0];
        yield [true, 2, 1];
        yield [false, 0.000_000, 0.000_000_1];
        yield [false, 0.000_000_49, 0.000_000_1];
        yield [false, 0.000_000_1, 0.000_000_51];
    }

    /**
     * @dataProvider is_greater_than_eq_data_provider
     */
    public function test_is_greater_than_eq(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isGreaterThanEq((string) $value, (string) $nextValue));
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public function is_greater_than_eq_data_provider() : \Generator
    {
        yield [true, 2.0, 1.0];
        yield [true, 2, 1];
        yield [true, 0.000_000, 0.000_000_1];
        yield [true, 0.000_000_49, 0.000_000_1];
        yield [false, 0.000_000_1, 0.000_000_51];
    }

    /**
     * @dataProvider is_less_than_eq_data_provider
     */
    public function test_is_less_than_eq(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isLessThanEq((string) $value, (string) $nextValue));
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public function is_less_than_eq_data_provider() : \Generator
    {
        yield [false, 2.0, 1.0];
        yield [false, 2, 1];
        yield [true, 0.000_000, 0.000_000_1];
        yield [true, 0.000_000_49, 0.000_000_1];
        yield [true, 0.000_000_1, 0.000_000_51];
    }
}
