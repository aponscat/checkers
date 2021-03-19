<?php
namespace Omatech\Checkers;

abstract class Player
{
    private string $color;

    public function __construct($color)
    {
        $this->color=$color;
    }

    public static function createPlayer(string $color, string $type): Player
    {
        assert($type=='c'||$type=='h');
        assert($color=='x'||$color=='o');
    
        if ($type=='h') {
            return new HumanPlayer($color);
        }
        return new ComputerPlayer($color);
    }


    public function getColor(): string
    {
        return $this->color;
    }



    abstract public function askForValidMovement(Board $board): Movement;
    abstract public function getSourceChoice(Board $board, array $valid_sources, ?array $killer_sources=[]): Tile;
    abstract public function getDestinationChoice(Board $board, Tile $source_tile): Tile;
}
