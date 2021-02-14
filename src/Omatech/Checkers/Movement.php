<?php
namespace Omatech\Checkers;

class Movement {
  private Board $board;
  private Tile $source;
  private Tile $destination;

  function __construct(Board $board, Tile $source, Tile $destination)
  {
    $this->board=$board;
    $this->source=$source;
    $this->destination=$destination;
  }

  function getSource(): Tile {
    return $this->source;
  }

  function getDestination(): Tile {
    return $this->destination;
  }

  function do(): void
  {
    $source_tile=$this->getSource();
    $destination_tile=$this->getDestination();
    $token=$source_tile->getToken();
    $token->moveTo($destination_tile);
    if ($this->board->tokenReachedGoal ($token))
    {
      $token->convertToQueen();
    }
  }

}