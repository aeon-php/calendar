<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\LeapSecond;
use Aeon\Calendar\Gregorian\LeapSeconds;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class LeapSecondTest extends TestCase
{
    public function test_serialization() : void
    {
        $leapSecond = LeapSeconds::load()->all()[0];

        $this->assertObjectEquals(
            $leapSecond,
            \unserialize(\serialize($leapSecond)),
            'isEqual'
        );
    }

    public function test_is_equal() : void
    {
        $leapSeconds = LeapSeconds::load()->all();

        $this->assertFalse($leapSeconds[0]->isEqual($leapSeconds[1]));
        $this->assertFalse($leapSeconds[0]->isEqual(new LeapSecond(DateTime::fromString('1972-01-01 00:00:00 UTC'), TimeUnit::seconds(12)),));
    }
}
