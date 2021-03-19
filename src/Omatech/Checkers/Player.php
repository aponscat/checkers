<?php
namespace Omatech\Checkers;

abstract class Player
{
    private string $color;

    public function __construct(string $color)
    {
        $this->color=$color;
    }

    public static function createPlayer(string $color, string $type, IO $io=null): Player
    {
        assert($type=='c'||$type=='h');
        assert($color=='x'||$color=='o');
    
        if ($type=='h') {
            return new HumanPlayer($color, $io);
        }
        return new ComputerPlayer($color);
    }

    public function getColor(): string
    {
        return $this->color;
    }

    abstract public function askForValidMovement(Movements $movements): Movement;
}
