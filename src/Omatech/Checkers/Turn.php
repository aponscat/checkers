<?php
namespace Omatech\Checkers;
class Turn {

  private array $players;
  private int $current_player;

  function __construct(array $players)
  {
    $this->players=$players;
    $this->current_player=0;
  }

  function getCurrentPlayer(): Player {
    return $this->players[$this->current_player];
  }

  function changeToNextPlayer(): void {
    $this->current_player++;
    if (!isset($this->players[$this->current_player])) 
    {
        $this->current_player=0;
    }
  }
}