<?php

declare(strict_types=1);

namespace Aeon\Calculator;

/**
 * @psalm-immutable
 */
interface Calculator
{
    public function precision() : int;

    public function modulo(string $value, string $divisor) : string;

    public function divide(string $value, string $divisor) : string;

    public function multiply(string $value, string $multiplier) : string;

    public function add(string $value, string $nextValue) : string;

    public function sub(string $value, string $nextValue) : string;

    public function isGreaterThan(string $value, string $nextValue) : bool;

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isGreaterThanOrEqualTo` instead. Will be removed with 2.0
     */
    public function isGreaterThanEq(string $value, string $nextValue) : bool;

    public function isGreaterThanOrEqualTo(string $value, string $nextValue) : bool;

    public function isLessThan(string $value, string $nextValue) : bool;

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isLessThanOrEqualTo` instead. Will be removed with 2.0
     */
    public function isLessThanEq(string $value, string $nextValue) : bool;

    public function isLessThanOrEqualTo(string $value, string $nextValue) : bool;

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(string $value, string $nextValue) : bool;

    public function isEqualTo(string $value, string $nextValue) : bool;
}
