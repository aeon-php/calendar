<?php

declare(strict_types=1);

namespace Aeon\Calendar\System;

use Aeon\Calendar\Exception\Exception;
use Aeon\Calendar\TimeUnit;

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
