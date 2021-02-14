<?php
namespace Omatech\Checkers;

class Turn {

  private $players=array();
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
    if ($this->current_player) {
        $this->current_player=0;
    }
    else {
      $this->current_player=1;
    }
  }

  function getPlayerByColor($color): Player
  {
    foreach ($this->players as $player)
    {
      if ($player->getColor()==$color) return $player;
    }
    return null;
  }

}