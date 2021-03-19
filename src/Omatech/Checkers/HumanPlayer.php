<?php
namespace Omatech\Checkers;

class HumanPlayer extends Player
{
    private IO $io;

    public function __construct(string $color, IO $io)
    {
        $this->io=$io;
        parent::__construct($color);
    }

    public function askForValidMovement(Movements $movements): Movement
    {
        echo $this->getColor()." enter a valid movement:\n";
        echo $movements;
        $sourceTile=$this->getSourceChoice($movements);
        $destinationTile=$this->getDestinationChoice($sourceTile, $movements);
        return new Movement($sourceTile, $destinationTile);
    }

    public function getSourceChoice(Movements $movements)
    {
        $message='Player with color '.$this->getColor().', please enter a valid source tile: ';
        return $this->askForInputTile($message, $movements->getSources());
    }

    private function getDestinationChoice(Tile $sourceTile, Movements $movements): Tile
    {
        $message='Player with color '.$this->getColor().', please enter a valid destination tile: ';
        return $this->askForInputTile($message, $movements->getDestinationsFromSource($sourceTile));
    }

    private function askForInputTile(string $message, array $possibilities): Tile
    {
        assert($possibilities);
        $input=$this->io->getInput($message);
        foreach ($possibilities as $possibility) {
            if ($possibility->getCoordinate()==$input) {
                return $possibility;
            }
        }
        echo "No es una casilla válida\n";
        return $this->askForInputTile($message, $possibilities);
    }
}
