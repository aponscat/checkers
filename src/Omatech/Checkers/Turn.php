<?php
namespace Omatech\Checkers;

class Turn {

  private Checkers $checkers;
  private int $current_player;

  function __construct($checkers)
  {
    $this->checkers=$checkers;
    $this->current_player=1;
  }

  function getCurrentPlayer(): Player {
    return $this->checkers->getPlayers()[$this->current_player];
  }

  function nextPlayer(): void {
    if ($this->current_player) {
        $this->current_player=0;
    }
    else {
      $this->current_player=1;
    }
  }



}