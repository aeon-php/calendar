<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\DateTimeIntervalIterator;
use Aeon\Calendar\Gregorian\Interval;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class DateTimeIntervalIteratorTest extends TestCase
{
    public function test_forward_even_iteration_right_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-05 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::rightOpen()
        );

        $this->assertEquals(TimeUnit::day(), $iterator->unit());
        $this->assertEquals(Interval::rightOpen(), $iterator->interval());
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->start());
        $this->assertEquals(DateTime::fromString('2020-01-05 00:00:00 UTC'), $iterator->end());
        $this->assertTrue($iterator->isForward());

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(4, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[1]);
    }

    public function test_forward_even_iteration_left_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-03 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::leftOpen()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(2, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[1]);
    }

    public function test_forward_even_iteration_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-03 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::open()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]);
    }

    public function test_forward_even_iteration_closed() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-03 00:00:00 UTC'),
            TimeUnit::day(),
            Interval::closed()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(3, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[1]);
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[2]);
    }

    public function test_forward_exceeded_iteration_right_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            TimeUnit::days(2),
            Interval::rightOpen()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_forward_exceeded_iteration_left_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            TimeUnit::days(2),
            Interval::leftOpen()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_forward_exceeded_iteration_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            TimeUnit::days(2),
            Interval::open()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_forward_exceeded_iteration_closed() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            TimeUnit::days(2),
            Interval::closed()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(1, $iterator);

        $array = \iterator_to_array($iterator);

        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]);
    }

    public function test_forward_odd_iteration_right_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            TimeUnit::days(3),
            Interval::rightOpen()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]);
    }

    public function test_forward_odd_iteration_left_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            TimeUnit::days(3),
            Interval::leftOpen()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[0]);
    }

    public function test_forward_odd_iteration_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            TimeUnit::days(3),
            Interval::open()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_forward_odd_iteration_closed() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            TimeUnit::days(3),
            Interval::closed()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(2, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[1]);
    }

    public function test_backward_even_iteration_right_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::rightOpen()
        );

        $this->assertFalse($iterator->isForward());

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(3, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[2]);
    }

    public function test_backward_even_iteration_left_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::leftOpen()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(3, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[2]);
    }

    public function test_backward_even_iteration_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::open()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(2, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[1]);
    }

    public function test_backward_even_iteration_closed() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative(),
            Interval::closed()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(4, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[3]);
    }

    public function test_backward_exceeded_iteration_right_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(2)->toNegative(),
            Interval::rightOpen()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_backward_exceeded_iteration_left_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(2)->toNegative(),
            Interval::leftOpen()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_backward_exceeded_iteration_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(2)->toNegative(),
            Interval::open()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_backward_exceeded_iteration_closed() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(2)->toNegative(),
            Interval::closed()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]);
    }

    public function test_backward_odd_iteration_right_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(3)->toNegative(),
            Interval::rightOpen()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]);
    }

    public function test_backward_odd_iteration_left_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(3)->toNegative(),
            Interval::leftOpen()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[0]);
    }

    public function test_backward_odd_iteration_open() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(3)->toNegative(),
            Interval::open()
        );

        $iterator->rewind();
        $this->assertEquals(null, $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $this->assertCount(0, $iterator);
    }

    public function test_backward_odd_iteration_closed() : void
    {
        $iterator = new DateTimeIntervalIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(3)->toNegative(),
            Interval::closed()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $iterator->current());
        $this->assertTrue($iterator->hasNext());

        $iterator->next();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(2, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-04 00:00:00 UTC'), $array[0]);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[1]);
    }
}
