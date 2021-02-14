<?php
namespace Omatech\Checkers;

class Movement {
  private Tile $source;
  private Tile $destination;

  function __construct(Tile $source, Tile $destination)
  {
    $this->source=$source;
    $this->destination=$destination;
  }

  function getSource(): Tile {
    return $this->source;
  }

  function getDestination(): Tile {
    return $this->destination;
  }
}