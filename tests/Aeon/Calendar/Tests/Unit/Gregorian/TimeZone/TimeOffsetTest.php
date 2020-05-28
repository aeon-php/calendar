<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian\TimeZone;

use Aeon\Calendar\Gregorian\TimeZone\TimeOffset;
use PHPUnit\Framework\TestCase;

final class TimeOffsetTest extends TestCase
{
    /**
     * @dataProvider valid_time_offset_data_provider
     */
    public function test_valid_time_offset(string $offset) : void
    {
        $this->assertTrue(TimeOffset::isValid($offset));
    }

    /**
     * @return \Generator<int, array{string}, mixed, void>
     */
    public function valid_time_offset_data_provider() : \Generator
    {
        yield ['00:00'];
        yield ['+00:00'];
        yield ['-00:00'];
        yield ['-10:00'];
        yield ['-10:30'];
        yield ['-10:15'];
        yield ['10:30'];
        yield ['10:15'];
        yield ['+14:00'];
    }

    /**
     * @dataProvider invalid_time_offset_data_provider
     */
    public function test_invalid_time_offset(string $offset) : void
    {
        $this->assertFalse(TimeOffset::isValid($offset));
    }

    /**
     * @return \Generator<int, array{string}, mixed, void>
     */
    public function invalid_time_offset_data_provider() : \Generator
    {
        yield ['abcd'];
        yield ['9999'];
        yield ['45:45'];
    }

    public function test_to_date_time_zone() : void
    {
        $this->assertInstanceOf(\DateTimeZone::class, TimeOffset::UTC()->toDateTimeZone());
    }
}
