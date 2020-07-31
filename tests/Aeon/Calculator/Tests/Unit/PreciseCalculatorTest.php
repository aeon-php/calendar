<?php

declare(strict_types=1);

namespace Aeon\Calculator\Tests\Unit;

use Aeon\Calculator\PreciseCalculator;
use PHPUnit\Framework\TestCase;

final class PreciseCalculatorTest extends TestCase
{
    public function test_initialization() : void
    {
        $calculator = PreciseCalculator::initialize(6);
        $secondInitialization = PreciseCalculator::initialize(6);
        $differentPrecision = PreciseCalculator::initialize(8);

        $this->assertEquals($calculator, $secondInitialization);
        $this->assertNotEquals($calculator, $differentPrecision);
    }
}
