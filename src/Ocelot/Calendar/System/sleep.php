<?php

declare(strict_types=1);

namespace Ocelot\Calendar\System;

use Ocelot\Calendar\Exception\Exception;
use Ocelot\Calendar\TimeUnit;

function sleep(TimeUnit $timeUnit) : void
{
    if ($timeUnit->isNegative()) {
        throw new Exception(\sprintf("Sleep time unit can't be negative, %s given", $timeUnit->inSecondsPreciseString()));
    }

    if ($timeUnit->inSeconds()) {
        \sleep($timeUnit->inSeconds());
    }

    if ($timeUnit->microsecond()) {
        \usleep($timeUnit->microsecond());
    }
}
