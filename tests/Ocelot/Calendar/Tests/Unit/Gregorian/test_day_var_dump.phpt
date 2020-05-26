--TEST--
Test day var dump
--FILE--
<?php

use Ocelot\Calendar\Gregorian\Day;

require __DIR__ . '/../../../../../../vendor/autoload.php';

\var_dump(Day::fromString('2020-01-01'));

--EXPECT--
object(Ocelot\Calendar\Gregorian\Day)#9 (3) {
  ["year"]=>
  int(2020)
  ["month"]=>
  int(1)
  ["day"]=>
  int(1)
}