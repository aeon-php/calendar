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

    public function divide(string $value, string $divisor) : string
    {
        if (!\is_numeric($value) || !\is_numeric($divisor)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        $result = \bcdiv($value, $divisor, $this->precision);

        if ($result !== null) {
            return $result;
        }

        throw new \LogicException("Divisor can't be 0");
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

    public function isGreaterThanEq(string $value, string $nextValue) : bool
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

    public function isLessThanEq(string $value, string $nextValue) : bool
    {
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \in_array(\bccomp($value, $nextValue, $this->precision), [-1, 0], true);
    }

    public function isEqual(string $value, string $nextValue) : bool
    {
        if (!\is_numeric($value) || !\is_numeric($nextValue)) {
            throw new InvalidTypeException('Expected values to be numeric string');
        }

        return \bccomp($value, $nextValue, $this->precision) === 0;
    }
}
