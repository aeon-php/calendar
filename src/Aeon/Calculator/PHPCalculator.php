<?php

declare(strict_types=1);

namespace Aeon\Calculator;

/**
 * @psalm-immutable
 */
final class PHPCalculator implements Calculator
{
    private int $precision;

    public function __construct(int $precision)
    {
        $this->precision = $precision;
    }

    public function precision() : int
    {
        return $this->precision;
    }

    public function divide(string $value, string $divisor) : string
    {
        return \number_format((float) $value / (float) $divisor, $this->precision, '.', '');
    }

    public function multiply(string $value, string $multiplier) : string
    {
        return \number_format((float) $value * (float) $multiplier, $this->precision, '.', '');
    }

    public function add(string $value, string $nextValue) : string
    {
        return \number_format((float) $value + (float) $nextValue, $this->precision, '.', '');
    }

    public function sub(string $value, string $nextValue) : string
    {
        return \number_format((float) $value - (float) $nextValue, $this->precision, '.', '');
    }

    public function isGreaterThan(string $value, string $nextValue) : bool
    {
        return (float) (\number_format((float) $value, $this->precision, '.', '')) >
            (float) (\number_format((float) $nextValue, $this->precision, '.', ''));
    }

    public function isGreaterThanEq(string $value, string $nextValue) : bool
    {
        return (float) (\number_format((float) $value, $this->precision, '.', '')) >=
            (float) (\number_format((float) $nextValue, $this->precision, '.', ''));
    }

    public function isLessThan(string $value, string $nextValue) : bool
    {
        return (float) (\number_format((float) $value, $this->precision, '.', '')) <
            (float) (\number_format((float) $nextValue, $this->precision, '.', ''));
    }

    public function isLessThanEq(string $value, string $nextValue) : bool
    {
        return (float) (\number_format((float) $value, $this->precision, '.', '')) <=
            (float) (\number_format((float) $nextValue, $this->precision, '.', ''));
    }

    public function isEqual(string $value, string $nextValue) : bool
    {
        return (float) (\number_format((float) $value, $this->precision, '.', '')) ==
            (float) (\number_format((float) $nextValue, $this->precision, '.', ''));
    }
}
