<?php
namespace Omatech\Checkers;

class ComputerPlayer extends Player
{
    public function askForValidMovement(Movements $movements): Movement
    {
        $choosenMovement=$movements->getRandom();
        echo "\n".$this->getColor()." is moving from ".$choosenMovement;
        echo "\n";
        sleep(1);
        return $choosenMovement;
    }
}
