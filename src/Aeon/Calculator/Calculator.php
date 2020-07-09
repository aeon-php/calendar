<?php

declare(strict_types=1);

namespace Aeon\Calculator;

/**
 * @psalm-immutable
 */
interface Calculator
{
    public function precision() : int;

    public function divide(string $value, string $divisor) : string;

    public function multiply(string $value, string $multiplier) : string;

    public function add(string $value, string $nextValue) : string;

    public function sub(string $value, string $nextValue) : string;

    public function isGreaterThan(string $value, string $nextValue) : bool;

    public function isGreaterThanEq(string $value, string $nextValue) : bool;

    public function isLessThan(string $value, string $nextValue) : bool;

    public function isLessThanEq(string $value, string $nextValue) : bool;

    public function isEqual(string $value, string $nextValue) : bool;
}
