<?php
namespace Omatech\Checkers;

class HumanPlayer extends Player {

  function askForValidMovement(): Movement {
    $source_tile=$this->getSourceTile();
    $destination_tile=$this->getDestinationChoice($source_tile);
    assert($source_tile->getRow()!=$destination_tile->getRow());
    echo "\n".$this->getColor()." is moving from ".$source_tile->getCoordinates()." to ".$destination_tile->getCoordinates();
    if ($destination_tile->getToken()!=null)
    {
      echo ' '.$destination_tile->getSymbol();
    }
    echo "\n";
    sleep(1);
    return new Movement($this->getBoard(), $source_tile, $destination_tile);
  }

  function getSourceChoice (?array $killer_sources, array $valid_sources): Tile
  {
    $input_source=$this->AskForInput('Player with color '.$this->getColor().', please enter a valid source tile: ', $valid_sources);
    $source_tile=$this->getBoard()->getTileFromInput($input_source);
    return $source_tile;
  }

  function getDestinationChoice (Tile $source_tile): Tile
  {
    $possible_destinations=$source_tile->getToken()->possibleDestinationTiles();
    if ($possible_destinations)
    {
      $input_destination=$this->AskForInput('Player with color '.$this->getColor().', please, enter a valid destination:'
      , $possible_destinations);
      $destination_tile=$this->getBoard()->getTileFromInput($input_destination);
      return $destination_tile;
    }
    else
    {
      die ("Tablas");
    }
  }

  function AskForInput($message, $possibilities): string {
    assert ($possibilities);
    $input=readline($message); 
    foreach ($possibilities as $possibility)
    {
      if ($possibility->getCoordinates()==$input) return $input;
    }
    echo "No es una casilla válida\n";
    return $this->AskForInput($message, $possibilities);
  }

}