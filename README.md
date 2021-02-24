# checkers
Checkers game

Run with:
php play.php


# UML Diagram

@startuml
Player <|-- ComputerPlayer
Player <|-- HumanPlayer
Checkers *-- Board
Checkers *-- "2" Player
Checkers *-- Turn
Checkers *-- IO
Turn *-- "2" Player
Board *-- Tile
Tile o-- Token
Player o-- Token
Trajectory o-- "1 starting" Tile
Trajectory o-- "n" Tile
Movement o-- "1 source" Tile
Movement o-- "1 destination" Tile
Movement o-- Board

class Checkers {}


abstract class Player {
  string color
}

class HumanPlayer {}

class Board {}
class IO {}

class Tile {
  int row
  int column
}

class Token {
  string symbol
  int row_direction
  boolean isQueen
}

class Turn {
  int current_player
}

class Trajectory {
  int x_direction
  int y_direction
}

class Movement {}
@enduml