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
      if ($source_tile->getRow()==$destination_tile->getRow()) die('no mola!');
      echo "\n".$player->getColor()." is moving from ".$source_tile->getCoordinates()." to ".$destination_tile->getCoordinates();
      if ($destination_tile->getToken()!=null)
      {
        echo ' '.$destination_tile->getSymbol();
      }
      echo "\n";
      sleep(1);
    }
    return new Movement($this->board, $source_tile, $destination_tile);
  }

  function getSourceTile(Player $player)
  {
    $simulate=$player->mustSimulate();
    $possible_sources=$this->board->getAllTilesForPlayer($player);
    echo "\n".$player->getColor()." those are your possible moves:\n";
    $valid_sources=$killer_sources=[];
    foreach ($possible_sources as $source) {
      $possible_destination_tiles=$source->getToken()->possibleDestinationTiles();
      if ($possible_destination_tiles)
      {
        foreach ($possible_destination_tiles as $destination)
        {
          echo $source->getCoordinates().' -> '.$destination->getCoordinates();
          $mov=new Movement($this->board, $source, $destination);
          if ($mov->isKillerMovement()) {
              echo " K";
              $killer_sources[]=$source;
          }
          echo "\n";
          $valid_sources[]=$source;
        }
      }
    }

    if ($valid_sources)
    {
      if ($killer_sources && $simulate)
      {
        shuffle($killer_sources);
        $input_source=$this->simulateOrAskForInput('Enter source player '.$player->getColor().' of type '.$player->getType().': ', $killer_sources, $simulate);
      }
      else
      {
        shuffle($valid_sources);
        $input_source=$this->simulateOrAskForInput('Enter source player '.$player->getColor().' of type '.$player->getType().': ', $valid_sources, $simulate);
      }
      $source_tile=$this->board->getTileFromInput($input_source);
      return $source_tile;
    }
    else
    {
      die ("Tablas");
    }
  }

  function getAIMoves (Tile $source, array $destinations): array
  {
    $killer=$normal=[];
    foreach ($destinations as $destination)
    {
      $mov=new Movement($this->board, $source, $destination);
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

  function getDestinationTile(Player $player, Tile $source_tile)
  {
    $simulate=$player->mustSimulate();
    $possible_destinations=$source_tile->getToken()->possibleDestinationTiles();
    if ($possible_destinations)
    {
      $best_destinations=$this->getAIMoves($source_tile, $possible_destinations);
      $input_destination=$this->simulateOrAskForInput('Enter destination player '.$player->getColor().' of type '.$player->getType().': '
      , $best_destinations, $simulate);
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
      if ($possibilities)
      {
        $tile=$possibilities[array_rand($possibilities)];
        $input=$tile->getCoordinates();
      }
      else
      {
        die('no tiene sentido\n');
      }
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