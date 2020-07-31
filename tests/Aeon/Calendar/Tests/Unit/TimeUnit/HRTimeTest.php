<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\TimeUnit;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\TimeUnit\HRTime;
use PHPUnit\Framework\TestCase;

final class HRTimeTest extends TestCase
{
    public function test_conversion_with_nanoseconds_smaller_than_0() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Nanoseconds can't be less than 0, given -1");

        HRTime::convert(0, -1);
    }

    /**
     * @dataProvider converting_hr_time_to_timeunit_data_provider
     */
    public function test_converting_hr_time_to_timeunit(string $expected, int $seconds, int $nanoseconds) : void
    {
        $this->assertSame($expected, HRTime::convert($seconds, $nanoseconds)->inSecondsPrecise());
    }

    /**
     * @return \Generator<int, array{string, int, int}, mixed, void>
     */
    public function converting_hr_time_to_timeunit_data_provider() : \Generator
    {
        yield ['0.000000', 0, 0];
        yield ['0.100000', 0, 100_000_000];
        yield ['0.100000', 0, 100_000_100];
        yield ['0.100009', 0, 100_009_000];
        yield ['0.100009', 0, 100_009_000_001];
        yield ['0.000005', 0, 5_000];
    }
}
