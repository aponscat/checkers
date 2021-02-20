<?php
namespace Omatech\Checkers;

class Trajectory {
    private int $x_direction;
    private int $y_direction;
    private array $ordered_tiles;

    function __construct (Tile $starting_tile, int $x_direction, int $y_direction)
    {
        assert($x_direction>=-1 && $y_direction<=1);
        assert($y_direction>=-1 && $y_direction<=1);
        assert($starting_tile!=null);

        $this->$x_direction=$x_direction;
        $this->$y_direction=$y_direction;
        $board=$starting_tile->getBoard();

        $tile=$starting_tile;
        do {
          $this->ordered_tiles[]=$tile;
          $tile=$board->getTile($tile->getRow()+$x_direction, $tile->getColumn()+$y_direction);
        } while ($board->checkInBounds($tile->getRow(), $tile->getColumn()));
    }

    function getTiles()
    {
        return $this->ordered_tiles;
    }

    function __toString()
    {
        $ret="Direction=".$this->x_direction.' '.$this->y_direction.":";
        foreach ($this->ordered_tiles as $tile)
        {
            $ret.=$tile;
        }
        return $ret;
    }
}