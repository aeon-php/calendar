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

namespace Aeon\Calendar\Gregorian\Holidays;

/**
 * @psalm-immutable
 */
final class HolidayLocaleName
{
    private string $locale;

    private string $name;

    public function __construct(string $locale, string $name)
    {
        $this->locale = (string) \mb_strtolower($locale);
        $this->name = $name;
    }

    public function locale() : string
    {
        return $this->locale;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function in(string $locale) : bool
    {
        return $this->locale === \mb_strtolower($locale);
    }
}
