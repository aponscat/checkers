<?php
namespace Omatech\Checkers;
class Checkers {

  private Board $board;
  private Turn $turn;
  private array $players_array;
  private IO $io;

  function __construct()
  {
    $this->board=new Board();
    $this->io=new IO();
  }

  function play(): void {
    
    $player1=$this->initPlayer('x');
    $player2=$this->initPlayer('o');

    $this->players_array=[$player1, $player2];
    $this->turn=new Turn($this);
    $this->board->init($this->players_array);

    do {
      $this->io->clearScreen();
      $this->io->printBoard($this->board);
      $movement=$this->turn->getCurrentPlayer()->askForValidMovement();
      $movement->do();
      $winner=$this->board->getWinner($this);
      if (!$winner) $this->turn->nextPlayer();
    } while (!$winner);

    $this->io->clearScreen();
    echo "The winner is ".$winner->getColor()."\n";
    $this->io->printBoard($this->board);
  }

  function initPlayer (string $color): Player
  {
    $type=$this->io->askForTypeOfPlayer($color);
    $player=$this->createPlayer($color, $type);
    return $player;
  }

  function createPlayer (string $color, string $type): Player
  {
    if ($type=='h')
    {
      return new HumanPlayer($this, $color);
    }
    return new ComputerPlayer($this, $color);
  }

  function getPlayers(): array
  {
    return $this->players_array;
  }

  function getBoard(): Board {
    return $this->board;
  }

  function getIO(): IO {
    return $this->io;
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

