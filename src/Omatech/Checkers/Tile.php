<?php
namespace Omatech\Checkers;

class Tile {

  private ?string $color;
  private int $row;
  private int $column;

  function __construct (?string $color, int $row, int $column)
  {
    $this->setColor($color);
    $this->setRow($row);
    $this->setColumn($column);
  }

  function setColor(?string $color) {
    $this->color=$color;
  }

  function getColor(): ?string
  {
    return $this->color;
  }

  function setRow(int $row) {
    $this->row=$row;
  }

  function getRow(): int
  {
    return $this->row;
  }

  function setColumn(int $column) {
    $this->column=$column;
  }

  function getColumn(): int
  {
    return $this->column;
  }

  function toString(): string {
    if ($this->color) return $this->getColor();
    return '_';
  }

}