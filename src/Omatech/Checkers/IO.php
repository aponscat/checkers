<?php
namespace Omatech\Checkers;

class IO {

  function askForValidMovement(Board $board, Player $player, $simulate=false): Movement {
    do {
      $input_source=$this->simulateOrAskForInput('Player '.$player->getColor().', enter source coordinates: ', $simulate);
    } while (!static::checkValidCoordinate($input_source) || !$board->isValidSourceFromInput($player, $input_source));
    $source_tile=$board->getTileFromInput($input_source);

    do {
      $input_destination=$this->simulateOrAskForInput('Player '.$player->getColor().', enter destination coordinates: ', $simulate);
    } while (!$this->checkValidCoordinate($input_destination) || !$board->isValidDestinationFromInput($player, $source_tile, $input_destination));
    $destination_tile=$board->getTileFromInput($input_destination);

    if ($simulate)
    {
      echo "\n".$player->getColor()." is moving from $input_source to $input_destination\n";
      sleep(1);
    }
    return new Movement($source_tile, $destination_tile);
  }

  function simulateOrAskForInput($message, $simulate=false): string {
    if ($simulate)
    {
      $input=rand(0, DIMENSIONS-1).'-'.rand(0, DIMENSIONS-1);
      echo '.';  
    }
    else
    {
      $input=readline($message); 
    }

    return $input;
  }

  function printBoard(Board $board)
  {
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
    echo "Current board is:\n";
    echo $board->toString();
  }

  public static function getCoordinateFromInput ($input): array {
    return explode('-', $input);    
  }

  public static function checkValidCoordinate ($input)
  {
    $input_array=static::getCoordinateFromInput($input);
    if (count($input_array)==2)
    {
      if ($input_array[0]>=0 && $input_array[1]>=0)
      {
        if ($input_array[0]<DIMENSIONS && $input_array[1]<DIMENSIONS)
        {
          return true;
        }
      }
    }
    return false;
  }

}