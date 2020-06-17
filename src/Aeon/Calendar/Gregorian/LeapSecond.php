<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\TimeUnit;
use Webmozart\Assert\Assert;

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
        Assert::greaterThanEq($offsetTAI->inSeconds(), 10);
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
