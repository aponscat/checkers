<?php
namespace Omatech\Checkers;

class Tile
{
    private ?Token $token;
    private Coordinate $coordinate;

    public function __construct(Coordinate $coordinate)
    {
        $this->coordinate=$coordinate;
    }

    public function setToken(Token $token): void
    {
        $this->token=$token;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getToken(): ?Token
    {
        if (isset($this->token)) {
            return $this->token;
        }
        return null;
    }

    public function getColor(): ?string
    {
        if (isset($this->token)) {
            return $this->token->getColor();
        }
        return '_';
    }

    public function getSymbol(): ?string
    {
        if (isset($this->token)) {
            return $this->token->getSymbol();
        }
        return '-';
    }

    public function getCoordinateString(): string
    {
        return (string)$this->coordinate;
    }

    public function removeToken(): void
    {
        if (isset($this->token)) {
            $this->token=null;
        }
    }

    public function isEmpty(): bool
    {
        return ($this->getToken()==null);
    }

    public function getRow(): int
    {
        return $this->coordinate->getRow();
    }

    public function getColumn(): int
    {
        return $this->coordinate->getColumn();
    }

    public function __toString(): string
    {
        return $this->getSymbol();
    }

    public function debugString(): string
    {
        $ret="\ntile debug: coordinates=".$this->getCoordinates();
        if ($this->getToken()) {
            return $ret." token=".$this->getSymbol()." for player=".$this->token->getPlayer()->getColor()."\n";
        } else {
            return "$ret\n";
        }
    }
}
