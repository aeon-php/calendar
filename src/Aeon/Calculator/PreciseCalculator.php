<?php

declare(strict_types=1);

namespace Aeon\Calculator;

final class PreciseCalculator
{
    private const PRECISION = 6;

    private static ?Calculator $instance = null;

    /**
     * @psalm-pure
     * @psalm-suppress ImpureStaticProperty
     */
    public static function initialize() : Calculator
    {
        if (self::$instance instanceof Calculator) {
            return self::$instance;
        }

        if (BCMathCalculator::supported()) {
            self::$instance = new BCMathCalculator(self::PRECISION);

            return self::$instance;
        }

        self::$instance = new PHPCalculator(self::PRECISION);

        return self::$instance;
    }
}
