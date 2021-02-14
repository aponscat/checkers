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

  function getNextRow(): int
  {
    return $this->getTile()->getRow()+$this->row_direction;
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

  function possibleDestinationTiles()
  {
      $board=$this->getTile()->getBoard();
      $res=[];
      $starting_row=$this->getTile()->getRow();
      $starting_column=$this->getTile()->getColumn();
      $i=0;
  
      //echo 'source: '.$this->getTile()->getCoordinates().' player '.$this->getPlayer()->getColor()." Symbol=".$this->getSymbol()."\n";

      foreach (range(1, $this->maxMovement) as $i) {
        $new_x=($starting_row+($this->row_direction*$i));
        $new_y=$starting_column+$i;
        //echo "trying $new_x-$new_y\n";

        if ($board->checkInBounds($new_x, $new_y)) {
            $destination_tile=$board->getTile($new_x, $new_y);
            if ($destination_tile->getColor() != $this->getColor()) {
                $res[]=$destination_tile;
                //echo "possible move to $new_x-$new_y\n";
            }
        }

        $new_y=$starting_column-$i;
        //echo "trying $new_x-$new_y\n";

        if ($board->checkInBounds($new_x, $new_y)) {
            $destination_tile=$board->getTile($new_x, $new_y);
            if ($destination_tile->getColor() != $this->getColor()) {
                $res[]=$destination_tile;
                //echo "possible move to $new_x-$new_y\n";
            }
        }

        if ($this->isQueen())
        {
          //echo "Is Queen!!!\n";
          $new_x=($starting_row+((-1*$this->row_direction)*$i));
          $new_y=$starting_column+$i;
          //echo "trying $new_x-$new_y\n";

          if ($board->checkInBounds($new_x, $new_y)) {
              $destination_tile=$board->getTile($new_x, $new_y);
              if ($destination_tile->getColor() != $this->getColor()) {
                  $res[]=$destination_tile;
                  //echo "possible move to $new_x-$new_y\n";
              }
          }

          $new_y=$starting_column-$i;
          //echo "trying $new_x-$new_y\n";

          if ($board->checkInBounds($new_x, $new_y)) {
              $destination_tile=$board->getTile($new_x, $new_y);
              if ($destination_tile->getColor() != $this->getColor()) {
                  $res[]=$destination_tile;
                  //echo "possible move to $new_x-$new_y\n";
          }
        }
      }
    }
    return $res;
}

}