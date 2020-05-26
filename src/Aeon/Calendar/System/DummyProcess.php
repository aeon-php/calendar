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

use Aeon\Calendar\TimeUnit;

/**
 * @codeCoverageIgnore
 */
final class DummyProcess implements Process
{
    public function sleep(TimeUnit $timeUnit) : void
    {
    }
}
