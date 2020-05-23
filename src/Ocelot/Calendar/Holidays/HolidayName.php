<?php

declare(strict_types=1);

namespace Ocelot\Ocelot\Calendar\Holidays;

use Ocelot\Ocelot\Calendar\Exception\HolidayException;
use Webmozart\Assert\Assert;

/**
 * @psalm-immutable
 */
final class HolidayName
{
    /**
     * @var array<HolidayLocaleName>
     */
    private array $localeHolidayNames;

    public function __construct(HolidayLocaleName ...$localeHolidayNames)
    {
        Assert::greaterThan(\count($localeHolidayNames), 0);
        Assert::count((array) \array_filter(
            $localeHolidayNames,
            function (HolidayLocaleName $localeHolidayName) : bool {
                return $localeHolidayName->in('en');
            }
        ), 1);
        $this->localeHolidayNames = $localeHolidayNames;
    }

    public function name(string $locale = 'en') : string
    {
        $localeNames = (array) \array_filter(
            $this->localeHolidayNames,
            fn(HolidayLocaleName $localeHolidayName) : bool => $localeHolidayName->in($locale)
        );

        if (!\count($localeNames)) {
            throw new HolidayException(\sprintf("Holiday %s does not have name in %s locale", $this->name('en'), $locale));
        }

        return \current($localeNames)->name();
    }
}