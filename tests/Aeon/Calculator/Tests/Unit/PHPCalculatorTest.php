<?php

declare(strict_types=1);

namespace Aeon\Calculator\Tests\Unit;

use Aeon\Calculator\PHPCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PHPCalculatorTest extends TestCase
{
    /**
     * @return \Generator<int, array{string, float, float}, mixed, void>
     */
    public static function add_data_provider() : \Generator
    {
        yield ['3.000000', 2.0, 1.0];
        yield ['3.000000', 2, 1];
        yield ['0.000200', 0.000_100, 0.000_100];
        yield ['0.000201', 0.000_101, 0.000_100];
        yield ['0.000000', 0.000_000, 0.000_000_1];
        yield ['0.000001', 0.000_000_49, 0.000_000_1];
    }

    /**
     * @return \Generator<int, array{string, float, float}, mixed, void>
     */
    public static function add_sub_provider() : \Generator
    {
        yield ['1.000000', 2.0, 1.0];
        yield ['1.000000', 2, 1];
        yield ['0.000000', 0.000_100, 0.000_100];
        yield ['0.000001', 0.000_101, 0.000_100];
        yield ['0.000000', 0.000_000, 0.000_000_1];
        yield ['0.000000', 0.000_000_49, 0.000_000_1];
    }

    /**
     * @return \Generator<int, array{string, float, float}, mixed, void>
     */
    public static function multiply_provider() : \Generator
    {
        yield ['2.000000', 2.0, 1.0];
        yield ['2.000000', 2, 1];
        yield ['0.000000', 0.000_100, 0.000_100];
        yield ['0.000000', 0.000_101, 0.000_100];
        yield ['0.000000', 0.000_000, 0.000_000_1];
        yield ['0.000000', 0.000_000_49, 0.000_000_1];
    }

    /**
     * @return \Generator<int, array{string, float, float}, mixed, void>
     */
    public static function divide_provider() : \Generator
    {
        yield ['1.000000', 1.0, 1.0];
        yield ['2.000000', 2, 1];
        yield ['1.000000', 0.000_100, 0.000_100];
        yield ['1.010000', 0.000_101, 0.000_100];
        yield ['0.000000', 0.000_000, 0.000_000_1];
        yield ['4.900000', 0.000_000_49, 0.000_000_1];
    }

    /**
     * @return \Generator<int, array{string, float, float}, mixed, void>
     */
    public static function modulo_provider() : \Generator
    {
        yield ['0.000000', 1.0, 1.0];
        yield ['0.000000', 2, 1];
        yield ['1.000000', 7, 2];
        yield ['1.999980', 7, 2.50001];
        yield ['0.000000', 0.000_100, 0.000_100];
        yield ['0.000001', 0.000_101, 0.000_100];
        yield ['0.000000', 0.000_000, 0.000_000_1];
        yield ['0.000000', 0.000_000_49, 0.000_000_1];
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public static function is_equal_data_provider() : \Generator
    {
        yield [false, 2.0, 1.0];
        yield [false, 2, 1];
        yield [true, 0.000_100, 0.000_100];
        yield [false, 0.000_101, 0.000_100];
        yield [true, 0.000_000, 0.000_000_1];
        yield [true, 0.000_000_49, 0.000_000_1];
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public static function is_less_data_provider() : \Generator
    {
        yield [false, 2.0, 1.0];
        yield [false, 2, 1];
        yield [false, 0.000_000, 0.000_000_1];
        yield [false, 0.000_000_49, 0.000_000_1];
        yield [true, 0.000_000_1, 0.000_000_51];
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public static function is_greater_data_provider() : \Generator
    {
        yield [true, 2.0, 1.0];
        yield [true, 2, 1];
        yield [false, 0.000_000, 0.000_000_1];
        yield [false, 0.000_000_49, 0.000_000_1];
        yield [false, 0.000_000_1, 0.000_000_51];
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public static function is_greater_than_eq_data_provider() : \Generator
    {
        yield [true, 2.0, 1.0];
        yield [true, 2, 1];
        yield [true, 0.000_000, 0.000_000_1];
        yield [true, 0.000_000_49, 0.000_000_1];
        yield [false, 0.000_000_1, 0.000_000_51];
    }

    /**
     * @return \Generator<int, array{bool, float, float}, mixed, void>
     */
    public static function is_less_than_eq_data_provider() : \Generator
    {
        yield [false, 2.0, 1.0];
        yield [false, 2, 1];
        yield [true, 0.000_000, 0.000_000_1];
        yield [true, 0.000_000_49, 0.000_000_1];
        yield [true, 0.000_000_1, 0.000_000_51];
    }

    public function test_precision() : void
    {
        $this->assertSame(6, (new PHPCalculator(6))->precision());
    }

    #[DataProvider('add_data_provider')]
    public function test_add(string $result, float $value, float $nextValue) : void
    {
        $this->assertSame($result, (new PHPCalculator(6))->add(\number_format($value, 9), \number_format($nextValue, 9)));
    }

    #[DataProvider('add_sub_provider')]
    public function test_sub(string $result, float $value, float $nextValue) : void
    {
        $this->assertSame($result, (new PHPCalculator(6))->sub(\number_format($value, 9), \number_format($nextValue, 9)));
    }

    #[DataProvider('multiply_provider')]
    public function test_multiply(string $result, float $value, float $nextValue) : void
    {
        $this->assertSame($result, (new PHPCalculator(6))->multiply(\number_format($value, 9), \number_format($nextValue, 9)));
    }

    #[DataProvider('divide_provider')]
    public function test_divide(string $result, float $value, float $nextValue) : void
    {
        $this->assertSame($result, (new PHPCalculator(6))->divide(\number_format($value, 9), \number_format($nextValue, 9)));
    }

    #[DataProvider('modulo_provider')]
    public function test_modulo(string $result, float $value, float $nextValue) : void
    {
        $this->assertSame($result, (new PHPCalculator(6))->modulo(\number_format($value, 9), \number_format($nextValue, 9)));
    }

    #[DataProvider('is_equal_data_provider')]
    public function test_is_equal(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isEqualTo(\number_format($value, 8), \number_format($nextValue, 8)));
    }

    #[DataProvider('is_less_data_provider')]
    public function test_is_less(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isLessThan(\number_format($value, 8), \number_format($nextValue, 8)));
    }

    #[DataProvider('is_greater_data_provider')]
    public function test_is_greater(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isGreaterThan(\number_format($value, 8), \number_format($nextValue, 8)));
    }

    #[DataProvider('is_greater_than_eq_data_provider')]
    public function test_is_greater_than_eq(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isGreaterThanOrEqualTo(\number_format($value, 8), \number_format($nextValue, 8)));
    }

    #[DataProvider('is_less_than_eq_data_provider')]
    public function test_is_less_than_eq(bool $equal, float $value, float $nextValue) : void
    {
        $this->assertSame($equal, (new PHPCalculator(6))->isLessThanOrEqualTo(\number_format($value, 8), \number_format($nextValue, 8)));
    }
}
