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
  }

  function isQueen(): bool
  {
    return ($this->isQueen);
  }

  function getAllTrajectories(): array
  {
    $trajectories=[];
    $trajectories[]=new Trajectory($this->getTile(), $this->row_direction, 1);
    $trajectories[]=new Trajectory($this->getTile(), $this->row_direction, -1);

    if ($this->isQueen)
    {
      $trajectories[]=new Trajectory($this->getTile(), $this->row_direction*-1, 1);
      $trajectories[]=new Trajectory($this->getTile(), $this->row_direction*-1, -1);
    }
    return $trajectories;
  }

  function getValidTileInTrajectory ($trajectory, $offset=0)
  {
    $valids=[];
    
    $tiles=$trajectory->getTiles($offset);
    if ($tiles && isset($tiles[$offset])) {
        if ($tiles[$offset]->isEmpty()) {
            $valids[]=$tiles[$offset];
            $valids=array_merge($valids, $this->getValidTileInTrajectory($trajectory, $offset+1));
        } else {
            if ($tiles[$offset]->getToken()
            && $tiles[$offset]->getToken()->getColor()!=$this->getColor()
            && isset($tiles[$offset+1])
            && $tiles[$offset+1]->isEmpty()
            ) {
                $valids[]=$tiles[$offset+1];
                $valids=array_merge($valids, $this->getValidTileInTrajectory($trajectory, $offset+2));
            }
        }
    }
    return $valids;
  }

  function possibleDestinationTiles (): array
  {
    $trajectories=$this->getAllTrajectories();
    $destinations=[];
    $i=0;
    do {
      foreach ($trajectories as $trajectory)
      {
        if ($trajectory->exists())
        {
          $destinations=array_merge($destinations, $this->getValidTileInTrajectory ($trajectory));
        }
      }
      $i++;
    } while ($i<$this->maxMovement);

    return $destinations;
  }
}