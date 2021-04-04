<?php declare(strict_types=1);

namespace Aeon\Calendar;

/**
 * @psalm-immutable
 */
interface Unit
{
    public function toDateInterval() : \DateInterval;

    public function invert() : self;

    public function absolute() : self;

    public function isNegative() : bool;
}
