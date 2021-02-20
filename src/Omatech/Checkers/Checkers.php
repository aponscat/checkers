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
    $this->turn=new Turn($this);

    $this->board=new Board();
    $this->board->init($this->players_array);
  }

  function play() {
    $io=new IO($this->board);
    $io->askForTypeOfPlayer($this->players_array[0]);
    $io->askForTypeOfPlayer($this->players_array[1]);
    do {
      $io->clearScreen();
      $io->printBoard($this->board);
      $movement=$io->askForValidMovement($this->turn->getCurrentPlayer());
      $movement->do();
      $winner=$this->board->getWinner($this);
      if (!$winner) $this->turn->nextPlayer();
    } while (!$winner);

    $io->clearScreen();
    echo "The winner is ".$winner->getColor()."\n";
    $io->printBoard($this->board);
  }

  function getPlayers()
  {
    return $this->players_array;
  }

  function getBoard() {
    return $this->board;
  }

  function getPlayerByColor($color): Player
  {
    foreach ($this->players_array as $player)
    {
      if ($player->getColor()==$color) return $player;
    }
    return null;
  }
}

