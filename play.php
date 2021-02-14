<?php

$autoload_location = '/vendor/autoload.php';
$tries=0;
while (!is_file(__DIR__.$autoload_location))
{
 $autoload_location='/..'.$autoload_location;
 $tries++;
 if ($tries>10) die("Error trying to find autoload file\n");
}
require_once __DIR__.$autoload_location;

use Omatech\Checkers\Checkers;

define ("DIMENSIONS", 8);
$checkers=new Checkers();
$checkers->play(true);

