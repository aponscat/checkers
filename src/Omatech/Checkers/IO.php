<?php
namespace Omatech\Checkers;

class IO {

  private Board $board;

  function __construct (Board $board) {
    $this->board=$board;
  }

  function askForTypeOfPlayer($player)
  {
    $input=readline("Select Human or Computer for player ".$player->getColor()." [C|h]:");
    if ('h'==strtolower($input))
    {
      $player->setHuman();
    }
    else
    {
      $player->setComputer();
    }
  }

  function askForValidMovement(Player $player): Movement {

    $simulate=$player->MustSimulate();
    $source_tile=$this->getSourceTile($player);
    $destination_tile=$this->getDestinationTile($player, $source_tile);
    if ($simulate)
    {
      echo "\n".$player->getColor()." is moving from ".$source_tile->getCoordinates()." to ".$destination_tile->getCoordinates()."\n";
      sleep(1);
    }
    return new Movement($this->board, $source_tile, $destination_tile);
  }

  function getSourceTile(Player $player)
  {
    $simulate=$player->mustSimulate();
    $possible_sources=$this->board->getAllTilesForPlayer($player);
    echo "\n".$player->getColor()." those are your possible moves:\n";
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
      $input_source=$this->simulateOrAskForInput('Enter source player '.$player->getColor().' of type '.$player->getType().': ', $res, $simulate);
      $source_tile=$this->board->getTileFromInput($input_source);
      return $source_tile;
    }
    else
    {
      die ("Tablas");
    }
  }

  function getDestinationTile(Player $player, Tile $source_tile)
  {
    $simulate=$player->mustSimulate();
    $possible_destinations=$source_tile->getToken()->possibleDestinationTiles();
    if ($possible_destinations)
    {
      $input_destination=$this->simulateOrAskForInput('Enter destination player '.$player->getColor().' of type '.$player->getType().': ', $possible_destinations, $simulate);
      $destination_tile=$this->board->getTileFromInput($input_destination);
      return $destination_tile;
    }
    else
    {
      die ("Tablas");
    }
  }

  function getBestMoveFromPossibilities($possibilities)
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
    return $tile;
  }

  function simulateOrAskForInput($message, $possibilities, $simulate=false): string {
    if ($simulate)
    {
      $tile=$this->getBestMoveFromPossibilities($possibilities);

      $input=$tile->getCoordinates();
    }
    else
    {
      $input=readline($message); 
    }

    foreach ($possibilities as $possibility)
    {
      if ($possibility->getCoordinates()==$input) return $input;
    }
    echo "No es una casilla válida\n";
    return $this->simulateOrAskForInput($message, $possibilities, $simulate);
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