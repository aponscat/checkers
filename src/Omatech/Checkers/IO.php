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
    $killer_sources=$normal_sources=[];
    foreach ($possible_sources as $source) {
      $possible_destination_tiles=$source->getToken()->possibleDestinationTiles();
      if ($possible_destination_tiles)
      {
        foreach ($possible_destination_tiles as $destination)
        {
          echo $source->getCoordinates().' -> '.$destination->getCoordinates();
          if ($destination->getToken())
          {
            echo ' '.$destination->getSymbol();
            $killer_sources[]=$source;
          }
          else
          {
            $normal_sources[]=$source;
          }
          echo "\n";
        }
      }
    }

    if (array_merge($killer_sources, $normal_sources))
    {
      $input_source=$this->simulateOrAskForInput('Enter source player '.$player->getColor().' of type '.$player->getType().': ', $killer_sources, $normal_sources, $simulate);
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
      $killer_possibilities=$normal_possibilities=[];
      foreach ($possible_destinations as $tile)
      {
        if($tile->getToken())
        {
          $killer_possibilities[]=$tile;
        }
        else
        {
          $normal_possibilities[]=$tile;
        }
      }

      $input_destination=$this->simulateOrAskForInput('Enter destination player '.$player->getColor().' of type '.$player->getType().': '
      , $killer_possibilities, $normal_possibilities, $simulate);
      $destination_tile=$this->board->getTileFromInput($input_destination);
      return $destination_tile;
    }
    else
    {
      die ("Tablas");
    }
  }


  function simulateOrAskForInput($message, $killer_possibilities, $normal_possibilities, $simulate=false): string {
    if ($simulate)
    {
      if ($killer_possibilities)
      {
        $tile=$killer_possibilities[array_rand($killer_possibilities)];
      }
      else
      {
        $tile=$normal_possibilities[array_rand($normal_possibilities)];
      }
      $input=$tile->getCoordinates();
    }
    else
    {
      $input=readline($message); 
    }

    foreach (array_merge($killer_possibilities, $normal_possibilities) as $possibility)
    {
      if ($possibility->getCoordinates()==$input) return $input;
    }
    echo "No es una casilla válida\n";
    return $this->simulateOrAskForInput($message, $killer_possibilities, $normal_possibilities, $simulate);
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