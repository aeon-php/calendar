--TEST--
Test system sleep
--FILE--
<?php

use Ocelot\Calendar\TimeUnit;
use Ocelot\Calendar\System\SystemProcess;
use Ocelot\Calendar\Gregorian\GregorianCalendar;

require __DIR__ . '/../../../../../../vendor/autoload.php';

$start = GregorianCalendar::UTC()->now();
(new SystemProcess())->sleep(TimeUnit::seconds(2));
$end = GregorianCalendar::UTC()->now();

var_dump($start->to($end)->distance()->inSeconds());

--EXPECTF--
int(2)