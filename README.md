# checkers
Checkers game

Run with:
php play.php


# UML Diagram

![UML DIAGRAM](http://www.plantuml.com/plantuml/png/rLLDRpCr4Bxlhx0Y3bkKzm372galJLk8K1je8pXKLUHufuc9rrxPtZIhal-EFppnxhOH4kB29R6V-PZ7ZpspNusbshQrA7uLj0DDVlZhonSoKtNJMj0H6vX-Rcig4pxR0jk1DkHRPxXML5T3QFBzX7pckcor72BpHU71SLJ86S6R-VtjmzDyyN0uhIPaoGKK_eSedrRjG2BP3q3ckDJqJs1MwIvuJRuZGGGkDvXnv20JVg_sK8Eqfp3LQWPdZ1KObv9QhZu9Hoe54zGOSjBYlIW8QHpXyi8jkEGsiY-DrOuVOKeexKqRI1PJfcr8Y9lveXnuNNSp7-d0Or4KTEtIKMP9h1vTN6r2-cKybNUdZENiI9W6QY6H2QMcqMjARDV0nMNA4ekcOfSfNmIVWbfU2M_n_ttY3WgBpF_Ilmf2F0iaV2JKxEwK_fqANg6StXFN0-TSTBPLd47fQpw_aBsFNiNBCrDobU0T5m8quaXndF0cNsilAubHA-lM67d4syMMGP7_-Gp_3V5_nnPx_tz3E0w9zzGlPUJz_9BU_uz2U7TJZlRkGD4p1IHpU9w7QTVRtcbLpwNJ93LXClt1fNJHsBeUjNxUF09bMwX-KbIKOG1TPAhpHK_FPTV0udNOtz-4dXerJYXEqAK6O-W6-ZwD-qzj5CLO-r_diLVSDnGJGFKJqm2oH1Gv1J6JUfPezPPMZaXRo-9CYngmuMpnXBdI1d47NONLQ21S3IP2Lw-LwC7eh7Jb7m6OmGpHKAizO7uioSrjtTZE8skbH4pngDuymCFZD77lDWEYit32lXj2sJFB5ChsPwG9vBDkgufhOFxX5YGm0IeTkTzQ09Jnm-p3wJuQdmzmGCP4lRuwOeaadcqHm3FsZyCtoXOwgQz0rZ-xCYNteDqb1jueSsuT_3BoU3VvI_dy4ft2b0WTDfVPMkRbb0ne1zSGt2XZ-5f0RmIapirU-JfQBK-lbhLQWxIh9cgOP0ZWPmgpBPKR9uYN6StZwyvyJrKE_HiEI9UHL3GIFdD0E71Z3JxKN0ldgAlK7wNbkS6O3NWhOxdH8vJbvfSmRx5ChrCgrJlvLv1LMuk_0G00)



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
Player *-- Board
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

  getSource(): Tile
  getDestination(): Tile
  getAllTilesInTrajectory(): Tile[]
  isKillerMovement(): bool
  do(): void
}
@enduml