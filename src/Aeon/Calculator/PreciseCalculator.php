<?php

declare(strict_types=1);

namespace Aeon\Calculator;

final class PreciseCalculator
{
    private static ?Calculator $instance = null;

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureStaticProperty
     */
    public static function initialize(int $precision) : Calculator
    {
        if (self::$instance instanceof Calculator && self::$instance->precision() === $precision) {
            return self::$instance;
        }

        if (BCMathCalculator::supported()) {
            self::$instance = new BCMathCalculator($precision);

            return self::$instance;
        }

        // @codeCoverageIgnoreStart
        self::$instance = new PHPCalculator($precision);

        return self::$instance;
        // @codeCoverageIgnoreEnd
    }
}
