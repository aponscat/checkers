<?php
namespace Omatech\Checkers;

class ComputerPlayer extends Player
{
    public function askForValidMovement(Movements $movements): Movement
    {
        echo $this->getColor()." enter a valid movement:\n";
        echo $movements;
        $choosenMovement=$movements->getAIMovement();
        echo "\n".$this->getColor()." is moving from ".$choosenMovement;
        echo "\n";
        sleep(1);
        return $choosenMovement;
    }
}
