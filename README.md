# checkers
Checkers game

Run with:
php play.php


# UML Diagram

![UML DIAGRAM](http://www.plantuml.com/plantuml/png/rLNDRY8v4BxtKrWeXoOYXztZQgLaboGpQ9Gmaw2PGnGXuww01xUDR3S1CRpxs6KRTnDuWBc0_RbS_kghdxunbchRrABuAkWMDFdtrzKL6QfwrLZG0UiSVMvgAYC-N01RWZR4uVyhggiEqlkxHquOJXejCw0SCXeN7YINtKleCO2teuUxn-VH-75pMFN8X0ie_0ywcQWboCJqyW1CDFq9p2gzHQlUNmG3vdAU71mPo8W_g3NK8EtXcceqWpE75HZdabgkJbuFsYJ88BsqIvHRa2aA9gWnvA3IhYW8MJd3ikyMN78RRfN6QXSAOKeetI_sHL7GcSCeioIuYDvtxbhRrllR6UiOiprX6gY5w16v3eBLWDZj2lh_f8mGCWSxz2Ub0uE_03wZEZvoV-B_0uxUF8IBW8t67d199yIpI8JtX9hblTBVgU1LagBCebtKSUak9xJO9wboMMAm9ts5WhgO-R-MatO4muNY34eVmCihMVlhqv1vCo3N4Lvo8K0dl1FlRIw4bgjOF5FhriayCS-zzYUI3wnsiIZB4CFBQpyu_4y8RsxAexqBBbZ62_4OosSpsBQszrhL8-dqYPKUZtvmATtjr1yUjRxTdu2o1LIV51Kbzdy_KnsDMzfEN5sFtxfDT16wg5lO-3X99ZKOG-VGjbcv_rZcGOoKeRNYlk2P0AgVcGQGPKGp9zGtg6U9LkznvOWqjIpEj901Yx652FDByuGxw1fNHmrxtUdORJrJeWkZiTALBm8mdHxNuDil-CzFSdDNh-pM8pEbH73nfDuzmB4uJTYxJOVe42DicoKeMsQPyDds33D8FkishRW6vWkt8CW4g7JalZK0ISQFiobc_sYyFS8cCIRgxSqHIoHZR6C4FvwV6Ov1Dkoa55TN_spAb5o3Tab4tbdcr3hfIyL3RlANw-Kr6E74m0uRoNnQvkM0T6YZALvUAMFuJ41h1CJEpLOv7OsMXwfbZTOWxNGLD8mo87XAORQWSku4yJBduswwCz_3AvkSuOXiMqZEi2dF10WRRgn9XPhVIdFKlTGUfUMvmPWFKbQEvKuM-2mtNt3UfcTQdLAfZv7dhztEWJSWgwOMlm40)



@startuml
Player <|-- ComputerPlayer
Player <|-- HumanPlayer
Checkers -- Board
Checkers -- "2" Player
Checkers -- Turn
Checkers o-- IO
Turn *-- "2" Player
Board *-- "DIMENSIONxDIMENSION" Tile
Tile o-- Token
Player *-- Token
Trajectory o-- "1 starting" Tile
Trajectory o-- "n" Tile
Movement o-- "1 source" Tile
Movement o-- "1 destination" Tile
Movement o-- Board
Movements *-- Movement
Player -- Movements

class Checkers {

  play()
  initPlayer(string color)
}


abstract class Player {
  string color

  {static} createPlayer(Board, color, type): Player
  getColor(): string
  getSourceTile(): Tile
  getBoard(): Board
  getIO(): IO
  
  {abstract} askForValidMovement(Movements $movement): Movement
}

class HumanPlayer {
  askForValidMovement(Board $board): Movement
  getSourceChoice(Tile[] valid_sources, ?Tile[] killer_sources): Tile
  getDestinationChoice(Tile source_tile): Tile
}

class ComputerPlayer {
  askForValidMovement(Board $board): Movement
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

class Movements {
}
@enduml