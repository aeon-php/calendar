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
        $this->assertSame('01', (RelativeTimeUnit::month())->toDateInterval()->format('%M'));
    }

    public function test_years() : void
    {
        $this->assertSame('02', (RelativeTimeUnit::years(2))->toDateInterval()->format('%Y'));
        $this->assertSame('01', (RelativeTimeUnit::year())->toDateInterval()->format('%Y'));
    }

    public function test_in_years() : void
    {
        $this->assertSame(2, RelativeTimeUnit::months(26)->inYears());
    }

    public function test_in_calendar_months() : void
    {
        $this->assertSame(4, RelativeTimeUnit::months(28)->inCalendarMonths());
    }

    public function test_in_months() : void
    {
        $this->assertSame(24, RelativeTimeUnit::years(2)->inMonths());
    }
}
