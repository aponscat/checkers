<?php
namespace Omatech\Checkers;

class Token
{
    private int $maxMovement=1;
    private Player $player;
    private Tile $tile;
    private string $symbol;
    private int $row_direction;
    private bool $isQueen=false;

    public function __construct(Player $player, Tile $tile)
    {
        $this->tile=$tile;
        $this->player=$player;
        $this->symbol=$player->getColor();
        if ($player->getColor()=='x') {
            $this->row_direction=1;
        } else {
            $this->row_direction=-1;
        }
    }

    public function getTile(): Tile
    {
        return $this->tile;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getNextRow(int $offset=1): int
    {
        return $this->getTile()->getRow()+($this->getRowOffset($offset));
    }

    public function getRowOffset(int $offset): int
    {
        return $offset*$this->row_direction;
    }

    public function getColor(): string
    {
        return $this->getPlayer()->getColor();
    }

    public function moveTo(Tile $tile): void
    {
        $this->tile->removeToken();
        $this->tile=$tile;
        $this->tile->setToken($this);
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function convertToQueen(): void
    {
        $this->maxMovement=DIMENSIONS-2;
        $this->symbol=strtoupper($this->symbol);
        $this->isQueen=true;
    }

    public function isQueen(): bool
    {
        return ($this->isQueen);
    }

    public function getAllTrajectories($board): array
    {
        $trajectories=[];
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), $this->row_direction, 1);
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), $this->row_direction, -1);

        if ($this->isQueen()) {
            $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), $this->row_direction*-1, 1);
            $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), $this->row_direction*-1, -1);
        }
        return $trajectories;
    }

    public function getValidTilesInTrajectory(Trajectory $trajectory, $offset=0): array
    {
        $valids=[];
    
        $tiles=$trajectory->getTiles($offset);
        if ($tiles && isset($tiles[$offset])) {
            if ($tiles[$offset]->isEmpty()) {
                $valids[]=$tiles[$offset];
                if ($this->isQueen()) {// recursive call if it's queen
                    $valids=array_merge($valids, $this->getValidTilesInTrajectory($trajectory, $offset+1));
                }
            } else {
                if ($tiles[$offset]->getToken()
            && $tiles[$offset]->getToken()->getColor()!=$this->getColor()
            && isset($tiles[$offset+1])
            && $tiles[$offset+1]->isEmpty()
            ) {
                    $valids[]=$tiles[$offset+1];
                    if ($this->isQueen()) {// recursive call if it's queen
                        $valids=array_merge($valids, $this->getValidTilesInTrajectory($trajectory, $offset+2));
                    }
                }
            }
        }
        return $valids;
    }

    public function possibleDestinationTiles(Board $board): array
    {
        $trajectories=$this->getAllTrajectories($board);
        $destinations=[];

        foreach ($trajectories as $trajectory) {
            if ($trajectory->exists()) {
                $destinations=array_merge($destinations, $this->getValidTilesInTrajectory($trajectory));
            }
        }

        return $destinations;
    }
}
