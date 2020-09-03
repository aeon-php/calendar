<?php declare(strict_types=1);

namespace Aeon\Calendar;

/**
 * @psalm-immutable
 */
interface Unit
{
    public function toDateInterval() : \DateInterval;
}
