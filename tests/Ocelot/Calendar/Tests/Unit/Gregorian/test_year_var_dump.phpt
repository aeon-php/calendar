--TEST--
Test day var dump
--FILE--
<?php

use Ocelot\Calendar\Gregorian\Year;

require __DIR__ . '/../../../../../../vendor/autoload.php';

\var_dump(new Year(2020));

--EXPECTF--
object(Ocelot\Calendar\Gregorian\Year)#%d (1) {
  ["year"]=>
  int(2020)
}