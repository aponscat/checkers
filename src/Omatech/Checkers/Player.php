<?php
namespace Omatech\Checkers;

abstract class Player {

  private string $color;
  private Checkers $checkers;

  function __construct($checkers, $color)
  {
    $this->checkers=$checkers;
    $this->color=$color;
  }

  public function getColor(): string {
    return strtolower($this->color);
  }

  public function getSourceTile(): Tile
  {
    $possible_sources=$this->getBoard()->getAllTilesForPlayer($this);
    echo "\n".$this->getColor()." those are your possible moves:\n";
    $valid_sources=$killer_sources=[];
    foreach ($possible_sources as $source) {
      $possible_destination_tiles=$source->getToken()->possibleDestinationTiles();
      if ($possible_destination_tiles)
      {
        foreach ($possible_destination_tiles as $destination)
        {
          echo $source->getCoordinates().' -> '.$destination->getCoordinates();
          $mov=new Movement($this->getBoard(), $source, $destination);
          if ($mov->isKillerMovement()) {
              echo " K";
              $killer_sources[]=$source;
          }
          echo "\n";
          $valid_sources[]=$source;
        }
      }
    }

    if ($valid_sources)
    {
      return $this->getSourceChoice($killer_sources, $valid_sources);
    }
    else
    {
      die ("Tablas");
    }
  }
  
  function getBoard(): Board
  {
    return $this->checkers->getBoard();
  }

  abstract function askForValidMovement(): Movement;
  abstract function getSourceChoice (?array $killer_sources, array $valid_sources): Tile;
  abstract function getDestinationChoice (Tile $source_tile): Tile;




}