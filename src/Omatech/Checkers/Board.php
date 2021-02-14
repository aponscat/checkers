<?php
namespace Omatech\Checkers;

class Board {

  private array $tiles;

  function __construct()
  {
    foreach (range(0, DIMENSIONS-1) as $row)
    {
      foreach (range(0, DIMENSIONS-1) as $column)
      {
        $this->tiles[$row][$column]=new Tile($this, $row, $column);
      }
    }
  }

  function getAllTilesForPlayer($player)
  {
    $ret=[];
    foreach (range(0, DIMENSIONS-1) as $row)
    {
      foreach (range(0, DIMENSIONS-1) as $column)
      {
        $tile=$this->tiles[$row][$column];
        if ($player->getColor()==$tile->getColor())
        {
          $ret[]=$tile;
        }
      }
    }  
    return $ret;  
  }

  function init ($players_array)
  {
    foreach (range(0, DIMENSIONS-1) as $row)
    {
      foreach (range(0, DIMENSIONS-1) as $column)
      {
        $tile=$this->tiles[$row][$column];
        $player=$this->getStartingPlayer($players_array, $row, $column);
        if ($player)
        {
          $token=new Token($player, $tile);
          $tile->setToken($token);
        }
      }
    }
  }

  function getTile ($x, $y): Tile
  {
    return $this->tiles[$x][$y];
  }

  function getTileFromInput ($input)
  {
    $coord=$this->getCoordinateFromInput($input);
    return $this->getTile($coord[0], $coord[1]);
  }

  function isValidSourceFromInput($player, $input)
  {
    //echo "entro a isValidSourceFromInput amb player ".$player->getColor()." i input $input\n";
    if (!$this->checkValidCoordinate($input)) return false;

    return $this->getTileFromInput($input)->getToken()->isValidSource($player);
  }

  function isValidDestinationFromInput($token, $input_destination)
  {
    if (!isset($token)) return false;
    if (!$this->checkValidCoordinate($input_destination)) return false;

    return $token->isValidDestination($this->getTileFromInput($input_destination));
  }

  function getWinner ($turn): ?Player {
    $xs=$os=0;

    foreach (range(0, DIMENSIONS-1) as $row)
    {
      foreach (range(0, DIMENSIONS-1) as $column)
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

  function tokenReachedGoal (Token $token): bool
  {
    if ($token->getPlayer()->getColor()=='x' && $token->getTile()->getRow()==DIMENSIONS-1) return true;
    if ($token->getPlayer()->getColor()=='o' && $token->getTile()->getRow()==0) return true;
    return false;
  }

  public function checkValidCoordinate (string $input): bool
  {
    $input_array=$this->getCoordinateFromInput($input);
    if (!isset($input_array) || !is_array($input_array)) return false;

    if (count($input_array)==2)
    {
      return $this->checkInBounds($input_array[0], $input_array[1]);
    }
    return false;
  }

  public static function getCoordinateFromInput (string $input): array {
    return explode('-', $input);    
  }

  function checkInBounds (int $x, int $y): bool {
    if ($x>=0 && $y>=0)
    {
      if ($x<DIMENSIONS && $y<DIMENSIONS)
      {
        return true;
      }
    }
    return false;
  }

  function __toString (): string {
    $ret='    ';
    foreach (range(0, DIMENSIONS-1) as $i)
    {
      $ret.="$i";
    }

    $ret.="\n";
    $i=0;
    foreach (range(0, DIMENSIONS-1) as $row)
    {
      $ret.="$i - ";
      foreach (range(0, DIMENSIONS-1) as $column)
      {
        $ret.=$this->tiles[$row][$column];
      }
      $ret.="\n";
      $i++;
    }
    return $ret;
  }

  private function getStartingPlayer($players_array, $row, $column): ?Player
  { 
    if (in_array($row, range(0,2))) 
    {
      if ($column%2!=$row%2)
      {
        return $players_array[0];
      }
    }
    if (in_array($row, range(DIMENSIONS-3, DIMENSIONS-1)))
    {
      if ($column%2!=$row%2)
      {
        return $players_array[1];
      }  
    }
    return null;
  }

}