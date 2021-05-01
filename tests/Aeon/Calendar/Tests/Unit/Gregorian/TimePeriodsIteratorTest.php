<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\Gregorian\TimePeriodsIterator;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimePeriodsIteratorTest extends TestCase
{
    public function test_forward_even_iterator_right_open() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::rightOpen()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-08 00:00:00 UTC'), $array[7]->start());
        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[7]->end());
    }

    public function test_forward_even_iterator_left_open() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::leftOpen()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[7]->start());
        $this->assertEquals(DateTime::fromString('2020-01-10 00:00:00 UTC'), $array[7]->end());
    }

    public function test_forward_even_iterator_open() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::open()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-07 00:00:00 UTC'), $array[5]->start());
        $this->assertEquals(DateTime::fromString('2020-01-08 00:00:00 UTC'), $array[5]->end());
        $this->assertEquals(DateTime::fromString('2020-01-08 00:00:00 UTC'), $array[6]->start());
        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[6]->end());
    }

    public function test_forward_even_iterator_closed() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::closed()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[8]->start());
        $this->assertEquals(DateTime::fromString('2020-01-10 00:00:00 UTC'), $array[8]->end());
    }

    public function test_backward_even_iterator_left_open() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::leftOpen()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-10 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[7]->start());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[7]->end());
    }

    public function test_backward_even_iterator_right_open() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::rightOpen()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-08 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[6]->start());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[6]->end());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[7]->start());
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[7]->end());
    }

    public function test_backward_even_iterator_open() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::open()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-08 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[5]->start());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[5]->end());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[6]->start());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[6]->end());
    }

    public function test_backward_even_iterator_closed() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-10 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::closed()
        );

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-10 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-09 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[8]->start());
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[8]->end());
    }

    public function test_forward_exceeded_iteration_closed() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-06 00:00:00 UTC'),
            TimeUnit::days(2),
            Interval::closed()
        );

        $this->assertCount(3, $iterator);

        $array = \iterator_to_array($iterator);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[1]->start());
        $this->assertEquals(DateTime::fromString('2020-01-05 00:00:00 UTC'), $array[1]->end());
        $this->assertEquals(DateTime::fromString('2020-01-05 00:00:00 UTC'), $array[2]->start());
        $this->assertEquals(DateTime::fromString('2020-01-06 00:00:00 UTC'), $array[2]->end());
    }

    public function test_backward_exceeded_iteration_closed() : void
    {
        $iterator = new TimePeriodsIterator(
            DateTime::fromString('2020-01-06 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(2)->toNegative(),
            Interval::closed()
        );

        $this->assertCount(3, $iterator);

        $array = \iterator_to_array($iterator);
        $this->assertEquals(DateTime::fromString('2020-01-06 00:00:00 UTC'), $array[0]->start());
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[0]->end());
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[1]->start());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[1]->end());
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[2]->start());
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[2]->end());
    }
}
