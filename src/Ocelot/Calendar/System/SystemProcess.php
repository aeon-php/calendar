<?php

declare(strict_types=1);

namespace Ocelot\Calendar\System;

use Ocelot\Calendar\TimeUnit;
use function Ocelot\Calendar\System\sleep as system_sleep;

final class SystemProcess implements Process
{
    public function sleep(TimeUnit $timeUnit): void
    {
        system_sleep($timeUnit);
    }
}