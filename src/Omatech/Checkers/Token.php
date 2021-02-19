<?php
namespace Omatech\Checkers;

class Token {
  private int $maxMovement=1;
  private Player $player;
  private Tile $tile;
  private string $symbol;
  private int $row_direction;
  private bool $isQueen=false; 

  function __construct (Player $player, Tile $tile)
  {
    $this->tile=$tile;
    $this->player=$player;
    $this->symbol=$player->getColor();
    if ($player->getColor()=='x') {
      $this->row_direction=1;
    }
    else 
    {
      $this->row_direction=-1;
    }
  }

  function getTile()
  {
    return $this->tile;
  }

  function getPlayer()
  {
    return $this->player;
  }

  function getNextRow($offset=1): int
  {
    return $this->getTile()->getRow()+($this->getRowOffset($offset));
  }

  function getRowOffset($offset)
  {
    return $offset*$this->row_direction;
  }

  function getColor()
  {
    return $this->getPlayer()->getColor();
  }

  function moveTo(Tile $tile)
  {
    $this->tile->removeToken();
    $this->tile=$tile;
    $this->tile->setToken($this);
  }

  function getSymbol()
  {
    return $this->symbol;
  }

  function convertToQueen(): void
  {
    $this->maxMovement=DIMENSIONS-2;
    $this->symbol=strtoupper($this->symbol);
    $this->isQueen=true;
    //$this->row_direction=$this->row_direction*-1;
  }

  function isQueen(): bool
  {
    return ($this->isQueen);
  }

  function tryMove ($row_offset, $column_offset): ?Tile {
    $current_row=$this->getTile()->getRow();
    $current_column=$this->getTile()->getColumn();

    $next_row=$this->getNextRow($row_offset);
    $next_column=$this->getTile()->getColumn()+$column_offset;
    
    //echo "Token in $current_row-$current_column trying to move with offset $row_offset-$column_offset to $next_row-$next_column\n";

    if ($this->tile->getBoard()->checkInBounds($next_row, $next_column))
    {
      $destination_tile=$this->getTile()->getBoard()->getTile($next_row, $next_column);
      if ($destination_tile->isEmpty())
      {
        return $destination_tile;
      }
      else
      {// o está ocupada por mi o por el otro jugador
        if ($destination_tile->getColor()!=$this->getColor())
        {// es el enemigo, tratamos de matarlo
          if ($this->tile->getBoard()->checkInBounds($this->getNextRow($row_offset+1), $next_column+$column_offset))
          {
            $destination_tile=$this->getTile()->getBoard()->getTile($this->getNextRow($row_offset+1), $next_column+$column_offset);
            if ($destination_tile->isEmpty())
            {
              return $destination_tile;
            }  
          }
        }
      }
    }
    return null;
  }

  function possibleDestinationTiles (): array
  {
    $destinations=[];

    if ($this->isQueen())
    {
      $i=-DIMENSIONS;
      do {
        $dest=$this->tryMove($i, $i);
        if ($dest) $destinations[]=$dest;
        
        $i++;
      } while ($i<$this->maxMovement);
    }
    else
    {
      $dest=$this->tryMove(1, +1);
      if ($dest) $destinations[]=$dest;
  
      $dest=$this->tryMove(1, -1);
      if ($dest) $destinations[]=$dest;  
    }

    return $destinations;
  }

}