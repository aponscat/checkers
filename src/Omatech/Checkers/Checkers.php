<?php
namespace Omatech\Checkers;

use Omatech\Checkers\Player;
use Omatech\Checkers\Board;
use Omatech\Checkers\Turn;

class Checkers {

  private Board $board;
  private Turn $turn;

  function __construct()
  {
    $player1=new Player('x');
    $player2=new Player('o');
    $this->turn=new Turn([$player1, $player2]);

    $this->board=new Board();
  }

  function play($simulate=false) {
    $io=new IO();
    do {
      $io->printBoard($this->board);
      $movement=$io->askForValidMovement($this->board, $this->turn->getCurrentPlayer(), $simulate);
      $this->board->makeMovement($movement);
      $winner=$this->board->getWinner($this->turn);
      if (!$winner) $this->turn->nextPlayer();
    } while (!$winner);

    echo "The winner is ".$winner->getColor()."\n";
    $io->printBoard($this->board);
  }

}

