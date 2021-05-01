<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit;

use Aeon\Calendar\RelativeTimeUnit;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-immutable
 */
final class RelativeTimeUnitTest extends TestCase
{
    public function test_months() : void
    {
        $this->assertSame('02', (RelativeTimeUnit::months(2))->toDateInterval()->format('%M'));
        $this->assertSame('02', (RelativeTimeUnit::months(-2))->toDateInterval()->format('%M'));
        $this->assertSame(1, (RelativeTimeUnit::months(-2))->toDateInterval()->invert);
        $this->assertSame('01', (RelativeTimeUnit::month())->toDateInterval()->format('%M'));
    }

    public function test_invert() : void
    {
        $this->assertSame(2, (RelativeTimeUnit::months(-2))->invert()->inMonths());
        $this->assertSame(-2, (RelativeTimeUnit::months(2))->invert()->inMonths());
        $this->assertSame(-2, (RelativeTimeUnit::years(2))->invert()->inYears());
        $this->assertSame(-24, (RelativeTimeUnit::years(2))->invert()->inMonths());
        $this->assertSame(2, (RelativeTimeUnit::years(-2))->invert()->inYears());
        $this->assertSame(24, (RelativeTimeUnit::years(-2))->invert()->inMonths());
    }

    public function test_years() : void
    {
        $this->assertSame('02', (RelativeTimeUnit::years(2))->toDateInterval()->format('%Y'));
        $this->assertSame('02', (RelativeTimeUnit::years(-2))->toDateInterval()->format('%Y'));
        $this->assertSame('01', (RelativeTimeUnit::year())->toDateInterval()->format('%Y'));
    }

    public function test_in_years() : void
    {
        $this->assertSame(0, RelativeTimeUnit::months(11)->inYears());
        $this->assertSame(1, RelativeTimeUnit::months(12)->inYears());
        $this->assertSame(-1, RelativeTimeUnit::months(-12)->inYears());
        $this->assertSame(0, RelativeTimeUnit::months(-1)->inYears());
        $this->assertSame(2, RelativeTimeUnit::months(26)->inYears());
        $this->assertSame(2, RelativeTimeUnit::years(2)->inYears());
    }

    public function test_in_calendar_months() : void
    {
        $this->assertSame(4, RelativeTimeUnit::months(28)->inCalendarMonths());
        $this->assertSame(4, RelativeTimeUnit::months(-28)->inCalendarMonths());
        $this->assertSame(0, RelativeTimeUnit::years(2)->inCalendarMonths());
    }

    public function test_in_months() : void
    {
        $this->assertSame(24, RelativeTimeUnit::years(2)->inMonths());
        $this->assertSame(24, RelativeTimeUnit::months(24)->inMonths());
    }

    public function test_to_date_interval() : void
    {
        $this->assertEquals(new \DateInterval('P0Y2M'), RelativeTimeUnit::months(2)->toDateInterval());
        $this->assertEquals(new \DateInterval('P2Y0M'), RelativeTimeUnit::years(2)->toDateInterval());
    }
}
