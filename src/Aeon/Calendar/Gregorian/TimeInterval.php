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

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class TimeInterval
{
    private DateTime $startDateTime;

    private TimeUnit $interval;

    private DateTime $endDateTime;

    public function __construct(DateTime $startDateTime, TimeUnit $interval, DateTime $endDateTime)
    {
        $this->startDateTime = $startDateTime;
        $this->interval = $interval;
        $this->endDateTime = $endDateTime;
    }

    public function startDateTime() : DateTime
    {
        return $this->startDateTime;
    }

    public function interval() : TimeUnit
    {
        return $this->interval;
    }

    public function endDateTime() : DateTime
    {
        return $this->endDateTime;
    }
}
