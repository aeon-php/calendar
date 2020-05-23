<?php

namespace Ocelot\Ocelot\Calendar\Gregorian;

/**
 * @psalm-immutable
 */
interface Calendar
{
    public function year() : Year;

    public function month() : Month;

    public function day() : Day;

    public function now() : DateTime;

    public function yesterday() : DateTime;

    public function tomorrow() : DateTime;
}