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

namespace Aeon\Calendar\System;

use function Aeon\Calendar\System\sleep as system_sleep;
use Aeon\Calendar\TimeUnit;

final class SystemProcess implements Process
{
    public function sleep(TimeUnit $timeUnit) : void
    {
        system_sleep($timeUnit);
    }
}
