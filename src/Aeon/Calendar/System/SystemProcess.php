<?php

declare(strict_types=1);

namespace Aeon\Calendar\System;

use Aeon\Calendar\TimeUnit;
use function Aeon\Calendar\System\sleep as system_sleep;

final class SystemProcess implements Process
{
    public function sleep(TimeUnit $timeUnit): void
    {
        system_sleep($timeUnit);
    }
}