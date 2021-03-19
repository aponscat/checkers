<?php
namespace Omatech\Checkers;

class ComputerPlayer extends Player
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
        if ($killer_sources) {
            shuffle($killer_sources);
            $input_source=$this->askForInput('Computer player with color '.$this->getColor().' selecting source: ', $killer_sources);
        } else {
            shuffle($valid_sources);
            $input_source=$this->askForInput('Computer player with color '.$this->getColor().' selecting source: ', $valid_sources);
        }
        $source_tile=$board->getTileFromInput($input_source);
        return $source_tile;
    }

    public function getDestinationChoice(Board $board, Tile $source_tile): Tile
    {
        $possible_destinations=$source_tile->getToken()->possibleDestinationTiles($board);
        if ($possible_destinations) {
            $best_destinations=$this->getAIMoves($board, $source_tile, $possible_destinations);
            $input_destination=$this->askForInput('Computer player with color '.$this->getColor().' selecting destination:', $best_destinations);
            $destination_tile=$board->getTileFromInput($input_destination);
            return $destination_tile;
        } else {
            die("Tablas");
        }
    }

    private function getAIMoves(Board $board, Tile $source, array $destinations): array
    {
        $killer=$normal=[];
        foreach ($destinations as $destination) {
            $mov=new Movement($source, $destination);
            if ($mov->isKillerMovement($board)) {
                $killer[]=$destination;
            } else {
                $normal[]=$destination;
            }
        }
        return array_merge($killer, $normal);
    }

    private function askForInput(string $message, array $possibilities): string
    {
        assert($possibilities);
        $tile=$possibilities[array_rand($possibilities)];
        $input=$tile->getCoordinateString();

        foreach ($possibilities as $possibility) {
            if ($possibility->getCoordinateString()==$input) {
                return $input;
            }
        }
        echo "No es una casilla válida\n";
        return $this->askForInput($message, $possibilities);
    }
}
