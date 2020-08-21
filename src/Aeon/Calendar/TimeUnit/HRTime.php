<?php

declare(strict_types=1);

namespace Aeon\Calendar\TimeUnit;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class HRTime
{
    /**
     * @psalm-pure
     */
    public static function convert(int $seconds, int $nanosecond) : TimeUnit
    {
        if ($nanosecond < 0) {
            throw new InvalidArgumentException("Nanoseconds can't be less than 0, given " . $nanosecond);
        }

        return TimeUnit::precise(\floatval(\sprintf(
            '%d.%s',
            $seconds,
            \str_pad(\strval($nanosecond), 9, '0', STR_PAD_LEFT)
        )));
    }
}
