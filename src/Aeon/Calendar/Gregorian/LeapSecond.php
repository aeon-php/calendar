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
    private DateTime $dateTime;

    private TimeUnit $offsetTAI;

    public function __construct(DateTime $dateTime, TimeUnit $offsetTAI)
    {
        if ($offsetTAI->inSeconds() < 10) {
            throw new InvalidArgumentException('Leap second TAI offset must be greater or equal 10');
        }

        $this->dateTime = $dateTime;
        $this->offsetTAI = $offsetTAI;
    }

    /**
     * @return array{dateTime: DateTime, offsetTAI: TimeUnit}
     */
    public function __serialize() : array
    {
        return [
            'dateTime' => $this->dateTime,
            'offsetTAI' => $this->offsetTAI,
        ];
    }

    public function dateTime() : DateTime
    {
        return $this->dateTime;
    }

    public function offsetTAI() : TimeUnit
    {
        return $this->offsetTAI;
    }

    /**
     * @infection-ignore-all
     *
     * @deprecated Use `isEqualTo` instead. Will be removed with 2.0
     */
    public function isEqual(self $second) : bool
    {
        return $this->isEqualTo($second);
    }

    public function isEqualTo(self $second) : bool
    {
        return $this->dateTime->isEqualTo($second->dateTime()) && $this->offsetTAI->isEqualTo($second->offsetTAI());
    }
}
