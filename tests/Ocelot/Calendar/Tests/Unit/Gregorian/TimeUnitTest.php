<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit\Gregorian;

use Ocelot\Calendar\Gregorian\TimeUnit;
use PHPUnit\Framework\TestCase;

final class TimeUnitTest extends TestCase
{
    public function test_time_unit_create_from_days() : void
    {
        $unit = TimeUnit::days(5);

        $this->assertSame(5, $unit->inDays());
        $this->assertSame(120, $unit->inHours());
        $this->assertSame(7200, $unit->inMinutes());
        $this->assertSame(432000, $unit->inSeconds());
    }

    public function test_time_unit_create_from_hours() : void
    {
        $unit = TimeUnit::hours(2);

        $this->assertSame(0, $unit->inDays());
        $this->assertSame(2, $unit->inHours());
        $this->assertSame(120, $unit->inMinutes());
        $this->assertSame(7200, $unit->inSeconds());
    }

    public function test_time_unit_create_from_minutes() : void
    {
        $unit = TimeUnit::minutes(2);

        $this->assertSame(0, $unit->inDays());
        $this->assertSame(0, $unit->inHours());
        $this->assertSame(2, $unit->inMinutes());
        $this->assertSame(120, $unit->inSeconds());
    }

    public function test_in_time_values() : void
    {
        $this->assertSame(8, TimeUnit::seconds(68)->inTimeSeconds());
        $this->assertSame(8, TimeUnit::minutes(68)->inTimeMinutes());
        $this->assertSame(15, TimeUnit::minutes(135)->inTimeMinutes());
    }
}