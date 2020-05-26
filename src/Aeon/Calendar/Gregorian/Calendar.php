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

namespace Aeon\Calendar\Gregorian;

interface Calendar
{
    public function year() : Year;

    public function month() : Month;

    public function day() : Day;

    public function now() : DateTime;

    public function yesterday() : DateTime;

    public function tomorrow() : DateTime;
}
