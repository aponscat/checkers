<?php
namespace Omatech\Checkers;
class Checkers {

  private Board $board;
  private Turn $turn;
  private array $players_array;

  function __construct()
  {
    $this->board=new Board();
  }

  function play() {
    $io=new IO($this->board);

    $color='x';
    $type=$io->askForTypeOfPlayer($color);
    $player1=$this->createPlayer($color, $type);

    $color='o';
    $type=$io->askForTypeOfPlayer($color);
    $player2=$this->createPlayer($color, $type);

    $this->players_array=[$player1, $player2];
    $this->turn=new Turn($this);
    $this->board->init($this->players_array);

    do {
      $io->clearScreen();
      $io->printBoard($this->board);
      $movement=$this->turn->getCurrentPlayer()->askForValidMovement();
      $movement->do();
      $winner=$this->board->getWinner($this);
      if (!$winner) $this->turn->nextPlayer();
    } while (!$winner);

    $io->clearScreen();
    echo "The winner is ".$winner->getColor()."\n";
    $io->printBoard($this->board);
  }

  function createPlayer (string $color, string $type): Player
  {
    if ($type=='h')
    {
      return new HumanPlayer($this, $color);
    }
    return new ComputerPlayer($this, $color);
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

