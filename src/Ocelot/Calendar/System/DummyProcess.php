<?php

declare(strict_types=1);

namespace Ocelot\Calendar\System;

use Ocelot\Calendar\TimeUnit;

final class DummyProcess implements Process
{
    public function sleep(TimeUnit $timeUnit): void
    {
    }
}