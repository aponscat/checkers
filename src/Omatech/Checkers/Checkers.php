<?php
namespace Omatech\Checkers;
class Checkers {

  private Board $board;
  private Turn $turn;
  private array $players_array;

  function __construct()
  {
    $player1=new Player('x');
    $player2=new Player('o');
    $this->players_array=[$player1, $player2];
    $this->turn=new Turn($this->players_array);

    $this->board=new Board();
    $this->board->init($this->players_array);
  }

  function play($simulate=false) {
    $io=new IO($this->board);
    do {
      $io->clearScreen();
      $io->printBoard($this->board);
      $movement=$io->askForValidMovement($this->turn->getCurrentPlayer(), $simulate);
      $movement->do();
      $winner=$this->board->getWinner($this->turn);
      if (!$winner) $this->turn->nextPlayer();
    } while (!$winner);

    $io->clearScreen();
    echo "The winner is ".$winner->getColor()."\n";
    $io->printBoard($this->board);
  }
}

