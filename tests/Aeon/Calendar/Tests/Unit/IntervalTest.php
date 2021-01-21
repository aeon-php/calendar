<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit;

use Aeon\Calendar\Gregorian\Interval;
use PHPUnit\Framework\TestCase;

final class IntervalTest extends TestCase
{
    public function test_open() : void
    {
        $interval = Interval::open();

        $this->assertTrue($interval->isLeftOpen());
        $this->assertTrue($interval->isRightOpen());
        $this->assertTrue($interval->isOpen());
        $this->assertFalse($interval->isClosed());
    }

    public function test_closed() : void
    {
        $interval = Interval::closed();

        $this->assertFalse($interval->isLeftOpen());
        $this->assertFalse($interval->isRightOpen());
        $this->assertFalse($interval->isOpen());
        $this->assertTrue($interval->isClosed());
    }

    public function test_left_open() : void
    {
        $interval = Interval::leftOpen();

        $this->assertTrue($interval->isLeftOpen());
        $this->assertFalse($interval->isRightOpen());
        $this->assertFalse($interval->isOpen());
        $this->assertFalse($interval->isClosed());
    }

    public function test_right_open() : void
    {
        $interval = Interval::rightOpen();

        $this->assertFalse($interval->isLeftOpen());
        $this->assertTrue($interval->isRightOpen());
        $this->assertFalse($interval->isOpen());
        $this->assertFalse($interval->isClosed());
    }
}
