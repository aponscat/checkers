<?php
namespace Omatech\Checkers;

class Tile {

  //private ?string $color;
  private ?Token $token;
  private int $row;
  private int $column;
  private Board $board;

  function __construct (Board $board, int $row, int $column)
  {
    $this->setRow($row);
    $this->setColumn($column);
    $this->board=$board;
  }

  function getBoard() {
    return $this->board;
  }

  function setToken(Token $token) {
    $this->token=$token;
  }

  function getToken(): ?Token {
    if (isset($this->token))
    {
      return $this->token;
    }
    return null;
  }

  function getColor(): ?string
  {
    if (isset($this->token))
    {
      return $this->token->getColor();
    }
    return '_';
  }

  function getSymbol(): ?string
  {
    if (isset($this->token))
    {
      return $this->token->getSymbol();
    }
    return '_';
  }

  function getCoordinates(): string
  {
    return $this->getRow().'-'.$this->getColumn();
  }

  function removeToken()
  {
    if (isset($this->token))
    {
      $this->token=null;
    }
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

  function __toString(): string {
    return $this->getSymbol();
  }

  function debugString(): string {
    $ret="\ntile debug: coordinates=".$this->getCoordinates();
    if ($this->getToken())
    {
      return $ret." token=".$this->getSymbol()." for player=".$this->token->getPlayer()->getColor()."\n";
    }
    else
    {
      return "$ret\n";
    }
  }
}