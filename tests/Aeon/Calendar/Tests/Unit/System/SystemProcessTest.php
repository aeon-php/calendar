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

namespace Aeon\Calendar\Tests\Unit\System;

use Aeon\Calendar\System\SystemProcess;
use Aeon\Calendar\TimeUnit;
use PHPUnit\Framework\TestCase;

final class SystemProcessTest extends TestCase
{
    public function test_sleeping_negative_time_unit() : void
    {
        $this->expectExceptionMessage("Sleep time unit can't be negative, -1.000000 given");

        (new SystemProcess())->sleep(TimeUnit::seconds(1)->invert());
    }
}
