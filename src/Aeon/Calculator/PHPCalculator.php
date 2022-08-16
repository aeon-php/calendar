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
        return \number_format(\floatval($value) / \floatval($divisor), $this->precision, '.', '');
    }

    public function modulo(string $value, string $divisor) : string
    {
        return \number_format(\fmod(\floatval($value), \floatval($divisor)), $this->precision, '.', '');
    }

    public function multiply(string $value, string $multiplier) : string
    {
        return \number_format(\floatval($value) * \floatval($multiplier), $this->precision, '.', '');
    }

    public function add(string $value, string $nextValue) : string
    {
        return \number_format(\floatval($value) + \floatval($nextValue), $this->precision, '.', '');
    }

    public function sub(string $value, string $nextValue) : string
    {
        return \number_format(\floatval($value) - \floatval($nextValue), $this->precision, '.', '');
    }

    public function isGreaterThan(string $value, string $nextValue) : bool
    {
        return \floatval(\number_format(\floatval($value), $this->precision, '.', '')) >
            \floatval(\number_format(\floatval($nextValue), $this->precision, '.', ''));
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isGreaterThanOrEqualTo` instead. Will be removed with 2.0
     */
    public function isGreaterThanEq(string $value, string $nextValue) : bool
    {
        return $this->isGreaterThanOrEqualTo($value, $nextValue);
    }

    public function isGreaterThanOrEqualTo(string $value, string $nextValue) : bool
    {
        return \floatval(\number_format(\floatval($value), $this->precision, '.', '')) >=
            \floatval(\number_format(\floatval($nextValue), $this->precision, '.', ''));
    }

    public function isLessThan(string $value, string $nextValue) : bool
    {
        return \floatval(\number_format(\floatval($value), $this->precision, '.', '')) <
            \floatval(\number_format(\floatval($nextValue), $this->precision, '.', ''));
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isLessThanOrEqualTo` instead. Will be removed with 2.0
     */
    public function isLessThanEq(string $value, string $nextValue) : bool
    {
        return $this->isLessThanOrEqualTo($value, $nextValue);
    }

    public function isLessThanOrEqualTo(string $value, string $nextValue) : bool
    {
        return \floatval(\number_format(\floatval($value), $this->precision, '.', '')) <=
            \floatval(\number_format(\floatval($nextValue), $this->precision, '.', ''));
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(string $value, string $nextValue) : bool
    {
        return $this->isEqualTo($value, $nextValue);
    }

    public function isEqualTo(string $value, string $nextValue) : bool
    {
        return \floatval(\number_format(\floatval($value), $this->precision, '.', '')) ==
            \floatval(\number_format(\floatval($nextValue), $this->precision, '.', ''));
    }
}
