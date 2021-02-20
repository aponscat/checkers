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
use Omatech\Checkers\Board;
use Omatech\Checkers\Trajectory;

define ("DIMENSIONS", 8);
$checkers=new Checkers();
$board=$checkers->getBoard();
$tiles=$board->getAllTiles();
foreach ($tiles as $tile)
{
    $tr1=new Trajectory($tile, 1, 1);
    $tr2=new Trajectory($tile, 1, -1);
    $tr3=new Trajectory($tile, -1, 1);
    $tr4=new Trajectory($tile, -1, -1);

    echo "Starting Tile:".$tile."\n";
    echo "tr1=".$tr1;
    echo "tr2=".$tr2;
    echo "tr3=".$tr3;
    echo "tr4=".$tr4;
}

