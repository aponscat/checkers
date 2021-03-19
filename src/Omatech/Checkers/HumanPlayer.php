<?php
namespace Omatech\Checkers;

class HumanPlayer extends Player
{
    public function askForValidMovement(Board $board): Movement
    {
        $source_tile=$board->getSourceTile($this);
        $destination_tile=$this->getDestinationChoice($board, $source_tile);
        assert($source_tile->getRow()!=$destination_tile->getRow());
        echo "\n".$this->getColor()." is moving from ".$source_tile->getCoordinateString()." to ".$destination_tile->getCoordinateString();
        if ($destination_tile->getToken()!=null) {
            echo ' '.$destination_tile->getSymbol();
        }
        echo "\n";
        sleep(1);
        return new Movement($source_tile, $destination_tile);
    }

    public function getSourceChoice(Board $board, array $valid_sources, ?array $killer_sources=[]): Tile
    {
        $input_source=$this->askForInput('Player with color '.$this->getColor().', please enter a valid source tile: ', $valid_sources);
        $source_tile=$board->getTileFromInput($input_source);
        return $source_tile;
    }

    public function getDestinationChoice(Board $board, Tile $source_tile): Tile
    {
        $possible_destinations=$source_tile->getToken()->possibleDestinationTiles($board);
        if ($possible_destinations) {
            $input_destination=$this->askForInput('Player with color '.$this->getColor().', please, enter a valid destination: ', $possible_destinations);
            $destination_tile=$board->getTileFromInput($input_destination);
            return $destination_tile;
        } else {
            die("Tablas");
        }
    }

    private function askForInput(string $message, array $possibilities): string
    {
        assert($possibilities);
        $io=$this->getIO();
        $input=$io->getInput($message);
        foreach ($possibilities as $possibility) {
            if ($possibility->getCoordinateString()==$input) {
                return $input;
            }
        }
        echo "No es una casilla válida\n";
        return $this->askForInput($message, $possibilities);
    }
}
