<?php

declare(strict_types=1);

/*
 * This file is part of the Aeon time management framework for PHP.
 *
 * (c) Norbert Orzechowicz <contact@norbert.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aeon\Calendar\Tests\Unit\Gregorian;

use Aeon\Calendar\Gregorian\Time;
use PHPUnit\Framework\TestCase;

final class TimeTest extends TestCase
{
    public function test_is_am() : void
    {
        $this->assertTrue((new Time(0, 0, 0, 0))->isAM());
        $this->assertfalse((new Time(0, 0, 0, 0))->isPM());
    }

    public function test_is_pm() : void
    {
        $this->assertFalse((Time::fromString('13:00:00'))->isAM());
        $this->assertTrue((Time::fromDateTime(new \DateTimeImmutable('13:00:00')))->isPM());
    }
}
