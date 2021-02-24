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
    
    $player1=$this->initPlayer('o');
    $player2=$this->initPlayer('x');

    $this->players_array=[$player1, $player2];
    $this->turn=new Turn($this->players_array);
    $this->board->init($this->players_array);

    do {
      $this->io->clearScreen();
      $this->io->printBoard($this->board);
      $movement=$this->turn->getCurrentPlayer()->askForValidMovement();
      $movement->do();
      $winner=$this->board->getWinner($this);
      if (!$winner) $this->turn->changeToNextPlayer();
    } while (!$winner);

    $this->io->clearScreen();
    echo "The winner is ".$winner->getColor()."\n";
    $this->io->printBoard($this->board);
  }

  function initPlayer (string $color): Player
  {
    $type=$this->io->askForTypeOfPlayer($color);
    $player=Player::createPlayer($this->board, $color, $type);
    return $player;
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

  function getPlayerByColor(string $color): Player
  {
    foreach ($this->players_array as $player)
    {
      if ($player->getColor()==$color) return $player;
    }
    return null;
  }
}

