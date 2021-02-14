<?php
namespace Omatech\Checkers;

class Player {

  private string $color;
  private int $row_direction;

  function __construct($color)
  {
    $this->color=$color;
    if ($color=='x') {
        $this->row_direction=1;
    }
    else {
      $this->row_direction=-1;
    }
  }

  function getColor(): string {
    return $this->color;
  }

  function getNextRow(int $row): int
  {
    return $row+$this->row_direction;
  }

}