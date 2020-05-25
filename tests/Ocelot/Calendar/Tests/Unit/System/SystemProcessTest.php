<?php

declare(strict_types=1);

namespace Ocelot\Calendar\Tests\Unit\System;

use Ocelot\Calendar\System\SystemProcess;
use Ocelot\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class SystemProcessTest extends TestCase
{
    public function test_sleeping_negative_time_unit() : void
    {
        $this->expectExceptionMessage("Sleep time unit can't be negative, -1.000000 given");

        (new SystemProcess())->sleep(TimeUnit::seconds(1)->invert());
    }
}