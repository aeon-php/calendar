--TEST--
Test day var dump
--FILE--
<?php

use Aeon\Calendar\Gregorian\Time;

require __DIR__ . '/../../../../../../vendor/autoload.php';

\var_dump(Time::fromString('13:00:00.000000'));

--EXPECTF--
object(Aeon\Calendar\Gregorian\Time)#%d (4) {
  ["hour"]=>
  int(13)
  ["minute"]=>
  int(0)
  ["second"]=>
  int(0)
  ["microsecond"]=>
  int(0)
}