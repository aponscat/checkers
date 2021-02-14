<?php
namespace Omatech\Checkers;

class Board {

  private array $tiles;
  private int $length=DIMENSIONS;

  function __construct()
  {
    foreach (range(0, $this->length-1) as $row)
    {
      foreach (range(0, $this->length-1) as $column)
      {
        $color=$this->getStartingColor($row, $column);
        $this->tiles[$row][$column]=new Tile($color, $row, $column);
      }
    }
  }

  function getTile ($x, $y): Tile
  {
    return $this->tiles[$x][$y];
  }

  function getTileFromInput ($input)
  {
    $coord=IO::getCoordinateFromInput($input);
    return $this->getTile($coord[0], $coord[1]);
  }

  function isValidSourceFromInput($player, $input)
  {
    if (!IO::checkValidCoordinate($input)) return false;

    return $this->isValidSource($player, $this->getTileFromInput($input));
  }

  function isValidSource($player, $tile)
  {
    if ($player->getColor()==$tile->getColor())
    {
      $next_row=$player->getNextRow($tile->getRow());
      if ($next_row>=0 && $next_row<DIMENSIONS)
      {
        $next_left_column=$tile->getColumn()-1;
        if ($next_left_column>=0 && $next_left_column<DIMENSIONS)
        {
          if ($this->isValidDestinationFromInput($player, $tile, $next_row.'-'.$next_left_column))
          {
            return true;
          }
        }

        $next_right_column=$tile->getColumn()+1;
        if ($next_right_column>=0 && $next_right_column<DIMENSIONS)
        {
          if ($this->isValidDestinationFromInput($player, $tile, $next_row.'-'.$next_right_column))
          {
            return true;
          }
        }

      }
    }
  }

  function isValidDestinationFromInput($player, $source_tile, $input)
  {
    if (!IO::checkValidCoordinate($input)) return false;

    return $this->isValidDestination($player, $source_tile, $this->getTileFromInput($input));
  }

  function isValidDestination($player, $source_tile, $destination_tile)
  {
    if ($player->getColor()!=$destination_tile->getColor())
    {
      if ($player->getNextRow($source_tile->getRow())==$destination_tile->getRow())
      {
        if ($source_tile->getColumn()==$destination_tile->getColumn()+1 || $source_tile->getColumn()==$destination_tile->getColumn()-1)
        {
          return true;
        }
      }
    }
  }

  function makeMovement (Movement $movement): void
  {
    $source_tile=$movement->getSource();
    $destination_tile=$movement->getDestination();
    $source_color=$source_tile->getColor();
    $source_tile->setColor(null);
    $destination_tile->setColor($source_color);
  }

  function getWinner ($turn): ?Player {
    $xs=0;
    $os=0;

    foreach (range(0, $this->length-1) as $row)
    {
      foreach (range(0, $this->length-1) as $column)
      {
        $color=$this->tiles[$row][$column]->getColor();
        if ($color=='o') $os++;
        if ($color=='x') $xs++;
      }
    }

    if ($os==0) return $turn->getPlayerByColor('x');
    if ($xs==0) return $turn->getPlayerByColor('o');
    return null;
  }

  function toString (): string {
    $ret='';
    foreach (range(0, $this->length-1) as $row)
    {
      foreach (range(0, $this->length-1) as $column)
      {
        $ret.=$this->tiles[$row][$column]->toString();
      }
      $ret.="\n";
    }
    return $ret;
  }

  private function getStartingColor($row, $column): ?string
  {
    if (in_array($row, range(0,2))) 
    {
      if ($column%2!=$row%2)
      {
        return 'x';
      }
    }
    if (in_array($row, range($this->length-3, $this->length-1)))
    {
      if ($column%2!=$row%2)
      {
        return 'o';
      }  
    }
  return null;
  }

}