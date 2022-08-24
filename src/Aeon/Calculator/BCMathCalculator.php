<?php

declare(strict_types=1);

namespace Aeon\Calculator;

use Aeon\Calculator\Exception\InvalidTypeException;

/**
 * @psalm-immutable
 */
final class BCMathCalculator implements Calculator
{
    private int $precision;

    public function __construct(int $precision)
    {
        $this->precision = $precision;
    }

    /**
     * @psalm-pure
     */
    public static function supported() : bool
    {
        return \extension_loaded('bcmath');
    }

    public function precision() : int
    {
        return $this->precision;
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function divide(string $value, string $divisor) : string
    {
        if (!\is_numeric($value) || !\is_numeric($divisor)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        if (\floatval($divisor) === \floatval('0')) {
            throw new \LogicException("Divisor can't be 0");
        }

        /**
         * @phpstan-ignore-next-line
         */
        return \bcdiv($value, $divisor, $this->precision);
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function modulo(string $value, string $divisor) : string
    {
        if (!\is_numeric($value) || !\is_numeric($divisor)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        if (\floatval($divisor) === \floatval('0')) {
            throw new \LogicException("Divisor can't be 0");
        }

        /**
         * @phpstan-ignore-next-line
         */
        return \bcmod($value, $divisor, $this->precision);
    }

    public function multiply(string $value, string $multiplier) : string
    {
        if (!\is_numeric($value) || !\is_numeric($multiplier)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \bcmul($value, $multiplier, $this->precision);
    }

    public function add(string $value, string $nextValue) : string
    {
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \bcadd($value, $nextValue, $this->precision);
    }

    public function sub(string $value, string $nextValue) : string
    {
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \bcsub($value, $nextValue, $this->precision);
    }

    public function isGreaterThan(string $value, string $nextValue) : bool
    {
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \bccomp($value, $nextValue, $this->precision) === 1;
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
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \in_array(\bccomp($value, $nextValue, $this->precision), [0, 1], true);
    }

    public function isLessThan(string $value, string $nextValue) : bool
    {
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \bccomp($value, $nextValue, $this->precision) === -1;
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
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \in_array(\bccomp($value, $nextValue, $this->precision), [-1, 0], true);
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
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \bccomp($value, $nextValue, $this->precision) === 0;
    }
}
