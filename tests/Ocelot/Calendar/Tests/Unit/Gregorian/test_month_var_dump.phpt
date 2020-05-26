--TEST--
Test day var dump
--FILE--
<?php

use Ocelot\Calendar\Gregorian\Month;

require __DIR__ . '/../../../../../../vendor/autoload.php';

\var_dump(Month::fromString('2020-01-01'));

--EXPECT--
object(Ocelot\Calendar\Gregorian\Month)#9 (2) {
  ["year"]=>
  int(2020)
  ["month"]=>
  int(1)
}