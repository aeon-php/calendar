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
}