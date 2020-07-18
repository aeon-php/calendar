<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian\Day;

use Aeon\Calendar\Gregorian\Day\WeekDay;
use PHPUnit\Framework\TestCase;

final class WeekDayTest extends TestCase
{
    public function test_equals() : void
    {
        $this->assertTrue(WeekDay::monday()->isEqual(WeekDay::monday()));
    }
}
