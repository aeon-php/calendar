<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class LeapSecond
{
    /**
     * @var DateTime
     */
    private DateTime $dateTime;

    /**
     * @var TimeUnit
     */
    private TimeUnit $offsetTAI;

    public function __construct(DateTime $dateTime, TimeUnit $offsetTAI)
    {
        if ($offsetTAI->inSeconds() < 10) {
            throw new InvalidArgumentException('Leap second TAI offset must be greater or equal 10');
        }

        $this->dateTime = $dateTime;
        $this->offsetTAI = $offsetTAI;
    }

    public function dateTime() : DateTime
    {
        return $this->dateTime;
    }

    public function offsetTAI() : TimeUnit
    {
        return $this->offsetTAI;
    }
}
