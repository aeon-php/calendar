# Aeon

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/aeon-php/calendar/license)](//packagist.org/packages/aeon-php/calendar)
![Tests](https://github.com/aeon-php/calendar/workflows/Tests/badge.svg?branch=master)

Time Management Framework for PHP

> The word aeon /ˈiːɒn/, also spelled eon (in American English), originally meant "life", "vital force" or "being", 
> "generation" or "a period of time", though it tended to be translated as "age" in the sense of "ages", "forever", 
> "timeless" or "for eternity".

[Source: Wikipedia](https://en.wikipedia.org/wiki/Aeon) 

This library is fully immutable wrapper for date/time objects provided by PHP. 
The goal is to simplify working with date and time through object oriented API. 
It works with precision up to microseconds if needed. 

## Examples

#### Creating calendar

```php
<?php 

use Aeon\Calendar\Gregorian\GregorianCalendar;

$calendar = GregorianCalendar::UTC();
```

#### Getting current time 

```php
<?php 

use Aeon\Calendar\Gregorian\GregorianCalendar;

$dateTime = GregorianCalendar::UTC()->now();
```

#### Iterating over time 

```php
<?php 

use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\TimeUnit;

$now = GregorianCalendar::UTC()->now();

$now->until($now->add(TimeUnit::days(7)))
    ->iterate(TimeUnit::day())
    ->each(function(TimePeriod $timePeriod) {
        echo $timePeriod->start()->day()->format('Y-m-d H:i:s.uO') . "\n";
    });
```

or with shorter syntax

```php
<?php 

use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\TimePeriod;
use Aeon\Calendar\TimeUnit;

$now = GregorianCalendar::UTC()->now();

$now->iterate($now->add(TimeUnit::days(7)), TimeUnit::day())
    ->each(function(TimePeriod $timePeriod) {
        echo $timePeriod->start()->day()->format('Y-m-d H:i:s.uO') . "\n";
    });
```

#### Measuring difference between two points in time

```php
<?php 

use \Aeon\Calendar\Gregorian\DateTime;

$start = DateTime::fromString('2020-01-01 00:00:00');
$end = DateTime::fromString('2020-01-10 00:00:00');

echo $start->until($end)->distance()->inDays(); // int(10)
```

#### Measuring difference between two points in time with leap second

```php
<?php 

use \Aeon\Calendar\Gregorian\DateTime;

$start = DateTime::fromString('2016-01-01 00:00:00 UTC');
$end = DateTime::fromString('2020-01-10 00:00:00 UTC');

echo $start->until($end)->distance()->inSeconds() . "\n"; 
echo $start->until($end)->distance()
    ->add($start->until($end)->leapSeconds()->count())
    ->inSeconds() . "\n"; 

// int(127008000)
// int(127008001)
```

#### Measuring elapsed time 

It might look tempting to use `Measuring difference between two points in time` to 
measure elapsed time if you are looking for precise results use `Stopwatch` class instead 
which is built on top of [\hrtime](https://www.php.net/manual/en/function.hrtime.php) high resolution time php function.

```php
<?php

use Aeon\Calendar\Stopwatch;
use Aeon\Calendar\TimeUnit;

$stopwatch = new Stopwatch();

$stopwatch->start();
usleep(TimeUnit::milliseconds(500)->microsecond());
$stopwatch->stop();
usleep(TimeUnit::milliseconds(700)->microsecond());
$stopwatch->stop();

var_dump($stopwatch->elapsedTime(1)->inSecondsPreciseString()); // ~0.500000
var_dump($stopwatch->firstElapsedTime()->inSecondsPreciseString()); // ~0.500000
var_dump($stopwatch->lastElapsedTime()->inSecondsPreciseString()); // ~0.700000
var_dump($stopwatch->elapsedTime(2)->inSecondsPreciseString()); // ~0.700000
var_dump($stopwatch->totalElapsedTime()->inSecondsPreciseString()); // ~1.200000
```

#### Iterating over all days in year

```php
<?php 

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\GregorianCalendar;

$days = GregorianCalendar::UTC()
    ->currentYear()
    ->mapDays(fn(Day $day) => $day->dayOfYear());
```

#### Creating DateTime from string 

```php
<?php 

use Aeon\Calendar\Gregorian\DateTime;

echo DateTime::fromString('2020-01-01 10:00:00')
    ->toISO8601(); // 2020-01-01T10:00:00+0000
```

#### Creating DateTime from primitive types

```php
<?php 

use Aeon\Calendar\Gregorian\DateTime;

echo DateTime::create(2020, 01, 01, 00, 00, 00, 0, 'UTC')
    ->toISO8601(); // 2020-01-01T00:00:00+0000
```

#### Creating DateTime from objects

```php
<?php 

use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Month;
use Aeon\Calendar\Gregorian\Time;
use Aeon\Calendar\Gregorian\TimeZone;
use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\Year;

echo (new DateTime(
        new Day(new Month(new Year(2020), 1), 1),
        new Time(00, 00, 00),
        TimeZone::UTC(),
        TimeZone\TimeOffset::fromString('0000')
    ))
    ->toISO8601(); // 2020-01-01T00:00:00+0000
```

#### Casting DateTime to different timezone string 

```php
<?php 

use Aeon\Calendar\Gregorian\DateTime;
use Aeon\Calendar\Gregorian\TimeZone;

echo DateTime::fromString('2020-01-01 10:00:00')
    ->toTimeZone(TimeZone::australiaSydney())
    ->toISO8601(); // 2020-01-01T21:00:00+1100
```

## Extensions

### Holidays

[Github: Calendar Holidays](https://github.com/aeon-php/calendar-holidays) 

Check if specific day is a holiday.  

```php
<?php 
use Aeon\Calendar\Gregorian\Day;
use Aeon\Calendar\Gregorian\Holidays\GoogleCalendarRegionalHolidays;
use Aeon\Calendar\Gregorian\Holidays\GoogleCalendar\CountryCodes;

$regionalHolidays = new GoogleCalendarRegionalHolidays(CountryCodes::PL);

echo $regionalHolidays->isHoliday(Day::fromString('2020-01-01')); // true 
```

### Process Sleep

[Github: Process](https://github.com/aeon-php/process)

Friendly sleep 

```php
SystemProcess::current()->sleep(TimeUnit::milliseconds(250));
```

### Doctrine Type

[Github: Doctrine Types](https://github.com/aeon-php/calendar-doctrine)

```yaml
# config/packages/doctrine.yaml

doctrine:
    dbal:
        types:
            aeon_date: Aeon\Calendar\Doctrine\Gregorian\DateType
            aeon_datetime: Aeon\Calendar\Doctrine\Gregorian\DateTimeType
            aeon_datetime_tz: Aeon\Calendar\Doctrine\Gregorian\DateTimeTzType
```
