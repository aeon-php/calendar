<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\TimeUnit;
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

    public function test_to_iterator_left_open() : void
    {
        $interval  = Interval::leftOpen();
        $iterator = \iterator_to_array($interval->toIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-05 00:00:00 UTC'), $iterator[3]);
    }

    public function test_to_iterator_open() : void
    {
        $interval  = Interval::open();
        $iterator = \iterator_to_array($interval->toIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator[2]);
    }

    public function test_to_iterator_right_open() : void
    {
        $interval  = Interval::rightOpen();
        $iterator = \iterator_to_array($interval->toIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator[3]);
    }


    public function test_to_iterator_closed() : void
    {
        $interval  = Interval::closed();
        $iterator = \iterator_to_array($interval->toIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-05 00:00:00 UTC'), $iterator[4]);
    }

    public function test_to_iterator_backward_left_open() : void
    {
        $interval  = Interval::leftOpen();
        $iterator = \iterator_to_array($interval->toIteratorBackward(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-05 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator[3]);
    }

    public function test_to_iterator_backward_open() : void
    {
        $interval  = Interval::open();
        $iterator = \iterator_to_array($interval->toIteratorBackward(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator[2]);
    }

    public function test_to_iterator_backward_open_short() : void
    {
        $interval  = Interval::open();
        $iterator = $interval->toIteratorBackward(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
        );

        $this->assertCount(0, $iterator);
    }

    public function test_to_iterator_backward_right_open() : void
    {
        $interval  = Interval::rightOpen();
        $iterator = \iterator_to_array($interval->toIteratorBackward(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator[3]);
    }


    public function test_to_iterator_backward_closed() : void
    {
        $interval  = Interval::closed();
        $iterator = \iterator_to_array($interval->toIteratorBackward(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day(),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
        ));

        $this->assertEquals(DateTime::fromString('2020-01-05 00:00:00 UTC'), $iterator[0]);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator[4]);
    }
}
