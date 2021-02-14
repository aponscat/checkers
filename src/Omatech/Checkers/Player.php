<?php
namespace Omatech\Checkers;

class Player {

  private string $color;

  function __construct($color)
  {
    $this->color=$color;
  }

  function getColor(): string {
    return strtolower($this->color);
  }



}