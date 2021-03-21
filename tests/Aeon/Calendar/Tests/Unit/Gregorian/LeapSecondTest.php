<?php

declare(strict_types=1);

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\LeapSeconds;
use PHPUnit\Framework\TestCase;

final class LeapSecondTest extends TestCase
{
    public function test_serialization() : void
    {
        $leapSecond = LeapSeconds::load()->all()[0];

        $this->assertSame(
            [
                'dateTime' => $leapSecond->dateTime(),
                'offsetTAI' => $leapSecond->offsetTAI(),
            ],
            $leapSecond->__serialize()
        );
        $this->assertSame(
            'O:34:"Aeon\Calendar\Gregorian\LeapSecond":2:{s:8:"dateTime";O:32:"Aeon\Calendar\Gregorian\DateTime":3:{s:3:"day";O:27:"Aeon\Calendar\Gregorian\Day":2:{s:5:"month";O:29:"Aeon\Calendar\Gregorian\Month":2:{s:4:"year";O:28:"Aeon\Calendar\Gregorian\Year":1:{s:4:"year";i:1972;}s:6:"number";i:1;}s:6:"number";i:1;}s:4:"time";O:28:"Aeon\Calendar\Gregorian\Time":4:{s:4:"hour";i:0;s:6:"minute";i:0;s:6:"second";i:0;s:11:"microsecond";i:0;}s:8:"timeZone";O:32:"Aeon\Calendar\Gregorian\TimeZone":2:{s:4:"name";s:3:"UTC";s:4:"type";i:2;}}s:9:"offsetTAI";O:22:"Aeon\Calendar\TimeUnit":3:{s:7:"seconds";i:10;s:11:"microsecond";i:0;s:8:"negative";b:0;}}',
            \serialize($leapSecond)
        );
    }
}
