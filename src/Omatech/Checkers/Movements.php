<?php
namespace Omatech\Checkers;

class Movements
{
    private array $movements=[];

    public function __construct(array $movements)
    {
        $this->movements=$movements;
    }

    public function getSources(): array
    {
        $sources=[];
        foreach ($this->movements as $movement) {
            $sources[]=$movement->getSource();
        }
        return $sources;
    }

    public function getDestinationsFromSource(Tile $source): array
    {
        $destinations=[];
        foreach ($this->movements as $movement) {
            if ($movement->getSource()->getCoordinate()==$source->getCoordinate()) {
                $destinations[]=$movement->getDestination();
            }
        }
        return $destinations;
    }

    public function getRandom(): Movement
    {
        return $this->movements[array_rand($this->movements)];
    }

    public function __toString(): string
    {
        $ret='';
        foreach ($this->movements as $movement) {
            $ret.="$movement\n";
        }
        return $ret;
    }
}
