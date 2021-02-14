<?php
namespace Omatech\Checkers;

class Player {

  private string $color;
  private string $type;

  function __construct($color)
  {
    $this->color=$color;
    $this->type='c';
  }

  function getColor(): string {
    return strtolower($this->color);
  }

  function setHuman()
  {
    $this->type='h';
  }

  function setComputer()
  {
    $this->type='c';
  }

  function mustSimulate()
  {
    return $this->type=='c';
  }

  function getType()
  {
    return $this->type;
  }

}