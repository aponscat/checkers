<?php
namespace Omatech\Checkers;

class Trajectory
{
    private int $x_direction;
    private int $y_direction;
    private ?array $ordered_tiles=null;

    public function __construct(Board $board, Coordinate $starting_coordinate, int $x_direction, int $y_direction)
    {
        assert($x_direction>=-1 && $y_direction<=1);
        assert($y_direction>=-1 && $y_direction<=1);
        assert($board!=null);
        assert($starting_coordinate!=null);

        $this->x_direction=$x_direction;
        $this->y_direction=$y_direction;

        $tile=$board->getTile($starting_coordinate);
        do {
            $tile=$board->getTile(new Coordinate($tile->getRow()+$x_direction, $tile->getColumn()+$y_direction));
            if ($tile) {
                $this->ordered_tiles[]=$tile;
            }
        } while ($tile);
    }

    public function getTiles(int $offset=0): array
    {
        $ret=[];
        foreach ($this->ordered_tiles as $key=>$tile) {
            if ($key>=$offset) {
                $ret[]=$tile;
            }
        }
        return $ret;
    }

    public function exists(): bool
    {
        return ($this->ordered_tiles!=null);
    }

    public function __toString(): string
    {
        $ret="StartingTile:".$this->starting_tile->getCoordinates()." ";
        $ret.="Direction=".$this->x_direction.' '.$this->y_direction.":";
        if ($this->exists()) {
            foreach ($this->ordered_tiles as $tile) {
                $ret.="(".$tile->getCoordinates()."),";
            }
        }
        $ret.="\n";
        return $ret;
    }
}
