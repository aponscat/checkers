<?php
namespace Omatech\Checkers;

class IO {

  function __construct (Board $board) {
    $this->board=$board;
  }

  function askForTypeOfPlayer(string $color): string
  {
    $valid=false;
    do {
      $input=readline("Select Human or Computer for player $color [C|h]:");
      if ($input==='') $input='c';
      $input=strtolower($input);
      if ($input=='c' || $input=='h') $valid=true;
    } while (!$valid);
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