<?php
namespace Omatech\Checkers;

class ComputerPlayer extends Player {

  function getAIMoves (Tile $source, array $destinations): array
  {
    $killer=$normal=[];
    foreach ($destinations as $destination)
    {
      $mov=new Movement($source, $destination);
      if ($mov->isKillerMovement())
      {
        $killer[]=$destination;
      }
      else
      {
        $normal[]=$destination;
      }
    }
    return array_merge($killer, $normal);
  }

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
    return new Movement($source_tile, $destination_tile);
  }

  function getSourceChoice (array $valid_sources, ?array $killer_sources=[]): Tile
  {
    if ($killer_sources)
    {
      shuffle($killer_sources);
      $input_source=$this->AskForInput('Computer player with color '.$this->getColor().' selecting source: ', $killer_sources);
    }
    else
    {
      shuffle($valid_sources);
      $input_source=$this->AskForInput('Computer player with color '.$this->getColor().' selecting source: ', $valid_sources);
    }
    $source_tile=$this->getBoard()->getTileFromInput($input_source);
    return $source_tile;
  }

  function getDestinationChoice (Tile $source_tile): Tile
  {
    $possible_destinations=$source_tile->getToken()->possibleDestinationTiles();
    if ($possible_destinations)
    {
      $best_destinations=$this->getAIMoves($source_tile, $possible_destinations);
      $input_destination=$this->AskForInput('Computer player with color '.$this->getColor().' selecting destination:'
      , $best_destinations);
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
    $tile=$possibilities[array_rand($possibilities)];
    $input=$tile->getCoordinates();

    foreach ($possibilities as $possibility)
    {
      if ($possibility->getCoordinates()==$input) return $input;
    }
    echo "No es una casilla válida\n";
    return $this->AskForInput($message, $possibilities);
  }




}