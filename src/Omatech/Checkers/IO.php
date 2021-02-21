<?php
namespace Omatech\Checkers;

class IO {

  function __construct () {
  }

  function askForTypeOfPlayer(string $color): string
  {
    $valid=false;
    do {
      $input=$this->getInput("Select Human or Computer for player $color [C|h]:");
      if ($input==='') $input='c';
      $input=strtolower($input);
      if ($input=='c' || $input=='h') $valid=true;
    } while (!$valid);
    return $input;
  }

  function getInput (string $message): string {
    return readline($message);
  }

  function printBoard(Board $board): void
  {
    echo "Current board is:\n";
    echo $board;
  }

  function clearScreen(): void
  {
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
  }

}