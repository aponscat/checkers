<?php

namespace Omatech\Checkers;

class Board
{
    private array $tiles;

    public function __construct()
    {
        foreach (range(0, DIMENSIONS - 1) as $row) {
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $this->tiles[$row][$column] = new Tile(new Coordinate($row, $column));
            }
        }
    }

    public function init(array $players_array = null): void
    {
        foreach (range(0, DIMENSIONS - 1) as $row) {
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $tile = $this->tiles[$row][$column];
                if ($players_array) {
                    $player = $this->getStartingPlayer($players_array, new Coordinate($row, $column));
                    if ($player) {
                        $token = new Token($player, $tile);
                        $tile->setToken($token);
                    }
                }
            }
        }
    }

    public function getAllPossibleMoves(string $color): Movements
    {
        $possibleMovements=[];
        $possibleSources=$this->getAllTilesForColor($color);
        foreach ($possibleSources as $source) {
            $possibleDestinations=$source->getToken()->possibleDestinationTiles($this);
            if ($possibleDestinations) {
                foreach ($possibleDestinations as $destination) {
                    $possibleMovements[]=new Movement($source, $destination);
                }
            }
        }
        return new Movements($possibleMovements);
    }

    public function getAllTiles(): array
    {
        $ret = [];
        foreach (range(0, DIMENSIONS - 1) as $row) {
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $ret[] = $this->tiles[$row][$column];
            }
        }
        return $ret;
    }

    public function getAllTilesForColor(string $color): array
    {
        $ret = [];
        foreach ($this->getAllTiles() as $tile) {
            if ($color == $tile->getColor()) {
                $ret[] = $tile;
            }
        }
        return $ret;
    }

    public function getTile(Coordinate $coordinate): ?Tile
    {
        if ($this->checkInBounds($coordinate)) {
            return $this->tiles[$coordinate->getRow()][$coordinate->getColumn()];
        }
        return null;
    }

    public function getTileFromInput(string $input): ?Tile
    {
        $coord = $this->getCoordinateFromInput($input);
        return $this->getTile(new Coordinate($coord[0], $coord[1]));
    }
 
    public function getWinnerColor(): ?string
    {
        $xs = $os = 0;

        foreach (range(0, DIMENSIONS - 1) as $row) {
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $color = $this->tiles[$row][$column]->getColor();
                if ($color == 'o') {
                    $os++;
                }
                if ($color == 'x') {
                    $xs++;
                }
            }
        }

        if ($os == 0) {
            return 'x';
        }
        if ($xs == 0) {
            return 'o';
        }
        return null;
    }

    public function tokenReachedGoal(Token $token): bool
    {
        if ($token->getPlayer()->getColor() == 'x' && $token->getTile()->getRow() == DIMENSIONS - 1) {
            return true;
        }
        if ($token->getPlayer()->getColor() == 'o' && $token->getTile()->getRow() == 0) {
            return true;
        }
        return false;
    }

    private function getCoordinateFromInput(string $input): array
    {
        return explode('-', $input);
    }

    private function checkInBounds(Coordinate $coordinate): bool
    {
        if ($coordinate->getRow() >= 0 && $coordinate->getColumn() >= 0) {
            if ($coordinate->getRow() < DIMENSIONS && $coordinate->getColumn() < DIMENSIONS) {
                return true;
            }
        }
        return false;
    }

    private function getStartingPlayer($players_array, Coordinate $coordinate): ?Player
    {
        if (in_array($coordinate->getRow(), range(0, 2))) {
            if ($coordinate->getColumn() % 2 != $coordinate->getRow() % 2) {
                return $players_array[1];
            }
        }
        if (in_array($coordinate->getRow(), range(DIMENSIONS - 3, DIMENSIONS - 1))) {
            if ($coordinate->getColumn() % 2 != $coordinate->getRow() % 2) {
                return $players_array[0];
            }
        }
        return null;
    }

    public function __toString(): string
    {
        $ret = '    ';
        foreach (range(0, DIMENSIONS - 1) as $i) {
            $ret .= "$i";
        }
        $ret .= "\n";
        $i = 0;
        foreach (range(0, DIMENSIONS - 1) as $row) {
            $ret .= "$i - ";
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $ret .= $this->tiles[$row][$column];
            }
            $ret .= "\n";
            $i++;
        }
        return $ret;
    }
}
