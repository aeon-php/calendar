<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\DateTimeIterator;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class DateTimeIteratorTest extends TestCase
{
    public function test_forward_even_iteration() : void
    {
        $iterator = new DateTimeIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-03 00:00:00 UTC'),
            TimeUnit::day()
        );

        $this->assertSame(0, $iterator->key());

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
        $this->assertEquals(DateTime::fromString('2020-01-03 00:00:00 UTC'), $array[2]);
    }

    public function test_forward_exceeded_iteration() : void
    {
        $iterator = new DateTimeIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            TimeUnit::days(2)
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-01 00:00:00 UTC'), $array[0]);
    }

    public function test_forward_odd_iteration() : void
    {
        $iterator = new DateTimeIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            TimeUnit::days(3)
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

    public function test_backward_even_iteration() : void
    {
        $iterator = new DateTimeIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()->toNegative()
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

    public function test_backward_exceeded_iteration() : void
    {
        $iterator = new DateTimeIterator(
            DateTime::fromString('2020-01-02 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(2)->toNegative()
        );

        $iterator->rewind();
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $iterator->current());
        $this->assertFalse($iterator->hasNext());

        $array = \iterator_to_array($iterator);

        $this->assertCount(1, $iterator);
        $this->assertEquals(DateTime::fromString('2020-01-02 00:00:00 UTC'), $array[0]);
    }

    public function test_backward_odd_iteration() : void
    {
        $iterator = new DateTimeIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(3)->toNegative()
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

    public function test_forward_with_negative_time_unit() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Forward DateTimeIterator 2020-01-01 00:00:00+00:00...2020-01-04 00:00:00+00:00 requires positive TimeUnit');

        new DateTimeIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            TimeUnit::days(3)->toNegative()
        );
    }

    public function test_backward_with_positive_time_unit() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Backward DateTimeIterator 2020-01-04 00:00:00+00:00...2020-01-01 00:00:00+00:00 requires negative TimeUnit');

        new DateTimeIterator(
            DateTime::fromString('2020-01-04 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::days(3)
        );
    }

    public function test_empty() : void
    {
        $iterator = new DateTimeIterator(
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            DateTime::fromString('2020-01-01 00:00:00 UTC'),
            TimeUnit::day()
        );

        $this->assertFalse($iterator->valid());
    }
}
