<?php

declare(strict_types=1);

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
