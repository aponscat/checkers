<?php
namespace Omatech\Checkers;

class Movement
{
    private Tile $source;
    private Tile $destination;
    private bool $killEvaluated=false;
    private bool $isKiller=false;

    public function __construct(Tile $source, Tile $destination)
    {
        $this->source=$source;
        $this->destination=$destination;
    }

    public function getSource(): Tile
    {
        return $this->source;
    }

    public function getDestination(): Tile
    {
        return $this->destination;
    }

    public function isKiller(): bool
    {
        assert($this->killEvaluated==true);
        return $this->isKiller;
    }

    public function getAllTilesInTrajectory(Board $board): array
    {
        $source_tile=$this->getSource();
        $destination_tile=$this->getDestination();

        $x=$source_tile->getRow();
        $y=$source_tile->getColumn();

        $dest_x=$destination_tile->getRow();
        $dest_y=$destination_tile->getColumn();

        $rows_offset=$this->getRowsOffset();
        $columns_offset=$this->getColumnsOffset();
        //echo "!!!$x-$y $rows_offset,$columns_offset to $dest_x-$dest_y!!!\n";
        $tiles=[];
        //echo "Trajectory: from $x-$y to $dest_x-$dest_y = ";
        do {
            $x=$x+$rows_offset;
            $y=$y+$columns_offset;
            //echo "$x-$y,";
            $next_tile=$board->getTile(new Coordinate($x, $y));
            $tiles[]=$next_tile;
        } while ($x<$dest_x || $y<$dest_y);
        //echo "\n";
        return $tiles;
    }

    public function evaluateIfIsKiller(Board $board): void
    {
        $this->killEvaluated=true;
        foreach ($this->getAllTilesInTrajectory($board) as $tile) {
            if ($tile->getToken() && $tile->getToken()->getColor()!=$this->source->getColor()) {
                $this->isKiller=true;
            }
        }
    }

    public function do(Board $board): void
    {
        $source_tile=$this->getSource();
        $destination_tile=$this->getDestination();
        $token=$source_tile->getToken();

        foreach ($this->getAllTilesInTrajectory($board) as $tile) {
            $tile->removeToken();
        }

        $token->moveTo($destination_tile);
        if ($board->tokenReachedGoal($token)) {
            $token->convertToQueen();
        }
    }

    private function getOffset(int $a, int $b): int
    {
        if ($a>$b) {
            $offset=-1;
        } else {
            $offset=+1;
        }
        return $offset;
    }

    private function getColumnsOffset(): int
    {
        return $this->getOffset($this->getSource()->getColumn(), $this->getDestination()->getColumn());
    }

    private function getRowsOffset(): int
    {
        return $this->getOffset($this->getSource()->getRow(), $this->getDestination()->getRow());
    }

    public function __toString(): string
    {
        $addStr='';
        if ($this->killEvaluated && $this->isKiller) {
            $addStr.=' K';
        }
        return $this->source->getCoordinate().' -> '.$this->destination->getCoordinate().$addStr;
    }
}
