<?php
namespace Omatech\Checkers;

class Movement {
  private Tile $source;
  private Tile $destination;

  function __construct(Tile $source, Tile $destination)
  {
    $this->source=$source;
    $this->destination=$destination;
  }

  function getSource(): Tile {
    return $this->source;
  }

  function getDestination(): Tile {
    return $this->destination;
  }

  function getOffset($a, $b): int
  {
    if ($a>$b)
    {
      $offset=-1;
    }
    else
    {
      $offset=+1;
    }
    return $offset;
  }

  function getColumnsOffset(): int
  {
    return $this->getOffset($this->getSource()->getColumn(), $this->getDestination()->getColumn());
  }

  function getRowsOffset(): int
  {
    return $this->getOffset($this->getSource()->getRow(), $this->getDestination()->getRow());
  }

  function getAllTilesInTrajectory(): array {
    $source_tile=$this->getSource();
    $destination_tile=$this->getDestination();
    $board=$source_tile->getBoard();

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
      $next_tile=$board->getTile($x, $y);
      $tiles[]=$next_tile;
    } while ($x<$dest_x || $y<$dest_y);
    //echo "\n";
    return $tiles;
  }

  function isKillerMovement(): bool
  {
    foreach ($this->getAllTilesInTrajectory() as $tile)
    {
      if ($tile->getToken() && $tile->getToken()->getColor()!=$this->source->getColor())
      {
        return true;
      }
    }
    return false;
  }

  function do(): void
  {
    $source_tile=$this->getSource();
    $destination_tile=$this->getDestination();
    $token=$source_tile->getToken();
    $board=$source_tile->getBoard();

    foreach ($this->getAllTilesInTrajectory() as $tile)
    {
      $tile->removeToken();
    }

    $token->moveTo($destination_tile);
    if ($board->tokenReachedGoal ($token))
    {
      $token->convertToQueen();
    }
  }

}