<?php
namespace Omatech\Checkers;

class IO {

  private Board $board;

  function __construct (Board $board) {
    $this->board=$board;
  }

  function askForValidMovement(Player $player, bool $simulate=false): Movement {

    $source_tile=$this->getSourceTile($player, $simulate);
    $destination_tile=$this->getDestinationTile($player, $source_tile, $simulate);
    if ($simulate)
    {
      echo "\n".$player->getColor()." is moving from ".$source_tile->getCoordinates()." to ".$destination_tile->getCoordinates()."\n";
      sleep(1);
    }
    return new Movement($this->board, $source_tile, $destination_tile);
  }

  function getSourceTile(Player $player, bool $simulate=false)
  {
    $possible_sources=$this->board->getAllTilesForPlayer($player);
    echo "\n".$player->getColor()." those are your possible sources:\n";
    $res=[];
    foreach ($possible_sources as $source) {
      $possible_destination_tiles=$source->getToken()->possibleDestinationTiles();
      if ($possible_destination_tiles)
      {
        $res[]=$source;
        foreach ($possible_destination_tiles as $destination)
        {
          echo $source->getCoordinates().' -> '.$destination->getCoordinates()."\n";
        }
      }
    }

    if ($res)
    {
      $input_source=$this->simulateOrAskForInput('Enter source: ', $res, $simulate);
      $source_tile=$this->board->getTileFromInput($input_source);
      return $source_tile;
    }
    else
    {
      die ("Tablas");
    }
  }

  function getDestinationTile(Player $player, Tile $source_tile, bool $simulate=false)
  {
    $possible_destinations=$source_tile->getToken()->possibleDestinationTiles();
    if ($possible_destinations)
    {
      $input_destination=$this->simulateOrAskForInput('Enter destination: ', $possible_destinations, $simulate);
      $destination_tile=$this->board->getTileFromInput($input_destination);
      return $destination_tile;
    }
    else
    {
      die ("Tablas");
    }
  }


  function simulateOrAskForInput($message, $possibilities, $simulate=false): string {
    if ($simulate)
    {
      $killer_tiles=[];
      foreach ($possibilities as $one_tile)
      {
        if ($one_tile->getToken())
        {
          $killer_tiles[]=$one_tile;
        }
      }

      if ($killer_tiles)
      {
        $tile=$possibilities[array_rand($killer_tiles)];
      }
      else
      {
        $tile=$possibilities[array_rand($possibilities)];
      }

      $input=$tile->getCoordinates();
    }
    else
    {
      $input=readline($message); 
    }

    return $input;
  }

  function printBoard(Board $board)
  {
    echo "Current board is:\n";
    echo $board;
  }

  function clearScreen()
  {
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
  }

}