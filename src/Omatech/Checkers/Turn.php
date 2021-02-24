<?php
namespace Omatech\Checkers;
class Turn {

  private array $players;
  private int $current_player;

  function __construct($players)
  {
    $this->players=$players;
    $this->current_player=0;
  }

  function getCurrentPlayer(): Player {
    return $this->players[$this->current_player];
  }

  function nextPlayer(): void {
    $this->current_player++;
    if (!isset($this->players[$this->current_player])) 
    {
        $this->current_player=0;
    }
  }
}