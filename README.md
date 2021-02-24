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
Board *-- "DIMENSIONxDIMENSION" Tile
Tile o-- Token
Player o-- Token
Trajectory o-- "1 starting" Tile
Trajectory o-- "n" Tile
Movement o-- "1 source" Tile
Movement o-- "1 destination" Tile
Movement o-- Board

class Checkers {
  play()
  initPlayer(string color)
  getPlayers()
  getBoard()
  getIO()
  getPlayerByColor()
}


abstract class Player {
  string color
  Board board

  {static} createPlayer(Board, color, type): Player
  getColor(): string
  getSourceTile(): Tile
  getBoard(): Board
  getIO(): IO
  
  {abstract} askForValidMovement(): Movement
  {abstract} getSourceChoice(Tile[] valid_sources, ?Tile[] killer_sources): Tile
  {abstract} getDestinationChoice(Tile source_tile): Tile
}

class HumanPlayer {
  askForValidMovement(): Movement
  getSourceChoice(Tile[] valid_sources, ?Tile[] killer_sources): Tile
  getDestinationChoice(Tile source_tile): Tile
}

class ComputerPlayer {
  askForValidMovement(): Movement
  getSourceChoice(Tile[] valid_sources, ?Tile[] killer_sources): Tile
  getDestinationChoice(Tile source_tile): Tile
}

class Board {
  init(Player[])
  getAllTiles()
  getAllTilesForPlayer(Player)
  getTile(x,y)
  getTileFromInput(string)
  getWinner(Checkers)
  tokenReachedGoal(Token)
}

class IO {
  askForTypeOfPlayer(string $color): string
  getInput (string message): string
  printBoard(Board board): void
  clearScreen(): void
}

class Tile {
  int row
  int column

  getBoard(): Board
  setToken(Token): void
  getToken(): ?Token
  getColor(): ?string
  getSymbol(): ?string
  getCoordinates(): string
  removeToken(): void
  isEmpty(): bool
  getRow(): int
  setRow(int): void
  getColumn(): int
  setColumn(int): void
}

class Token {
  string symbol
  int row_direction
  boolean isQueen

  getTile(): Tile
  getPlayer(): Player
  getNextRow(int offset): int
  getRowOffset(int offset): int
  getColor(): string
  moveTo(Tile): void
  getSymbol(): string
  convertToQueen(): void
  getAllTrajectories(): Trajectory[]
  getValidTilesInTrajectory(Trajectory, int offset): Tiles[]
  possibleDestinationTiles(): Tiles[]
}

class Turn {
  int current_player

  getCurrentPlayer(): Player
  changeToNextPlayer(): void
}

class Trajectory {
  int x_direction
  int y_direction

  getTiles(int offset): Tiles[]
  exists(): bool
}

class Movement {
  Tile source
  Tile destination

  getSource(): Tile
  getDestination(): Tile
  getAllTilesInTrajectory(): Tile[]
  isKillerMovement(): bool
  do(): void
}
@enduml