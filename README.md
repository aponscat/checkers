# checkers
Checkers game

Run with:
php play.php


# UML Diagram

![UML DIAGRAM](http://www.plantuml.com/plantuml/png/hLNFR-is3Bxxhn2279o7lCDs70QiMzfknj1cQuFjK1I5OZEfLbaA93cDaUL_7_L3bfMcm0xlaaWVAVBZHqg-qeOgqxMy-8FJ7XJvyT-lNyb2jhlEWF9OPlgjQwa8-E8LwZTGcY3-YwIgoP39znDomN7LAP40YKYrB2n8lkI7N4GFNbTtD_UFrVB-CAmcPCKu5FR71Ld9Dn2HwPS1M2dw3zH6gjvvJKGuToVtq88m7lsEQDcf6ZunDg0D4zGmUNuyLHuHNrBSHK8ZI1T5pQdMPD3WM1I4xD2ndE622MRygL8RnSIMr99BDIjEHL7GDMAqDiI72D6FU6piQ-CTjK72zOdK2gY12n7dyOpfTp37Bf0faxCVelo4RC4ih6E9e7T5q8QEB4w4whTRgVwYd3MnlZ8fCMt34WCCYfn2_NwIKWN_DvQ-62nExBUAvuVl6FfH-h1FppCloy-Ssp7GvTaUytdFS22OhQqypFlHzbR9jX98ERGacFvcGk3fE1eMDNQE7u3Mhz3yAYaltM3F4bLiN2ftXRrSRl9kJrsxXoRwJ2uvYIujQ4stCFRPuRznCfHUZBNzHO-zP0tQQmvKFTOAG9G1JPniYK4zGvHy3oiaqhMYy0nyR3pg5eXfCAusNs7Aj8quGZ-vLJQS28uBU-pRjUGPx9sbQkmb1ftDim8x23v-IidqJRiplKNMKd8Vua6-Mm0BiMJz7ZSPqOMhC7CBKF9CChcqu-kh7Vcasql35DJsuK7CCW4gaDoV7Q08QPfiFlllaT3ziwjy3uV8cCZD1eaD97rjImT-i7_s47ZPIfisrfNhdrnhAVQWi8d8EycShavyevdlJNgpdvwzaxl4xePL8bdBj9oJZBPpTOTtKcksvd2Tdl1mSvDNQaUdn32rTQSK2FEoyne66JnuGU7wbOej2c9bJkQytOdlaEMGEXoGVeIa3kloamBXmBJHSL1Jhk4BTGnjSH-uV516eYH3RCgvsj73PzrJtb43rQRIlpFEGOL7OkfVYU7Qi6XEK2Dptrobn5pdr5sDL2dQ1uvLT7HtFMu-LARjKnkgTy_ILBjD7ks1YaQsPVujk0BHT2t_3m00)


´´´
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
Trajectory o-- "n" Tile
Movement o-- "1 source" Tile
Movement o-- "1 destination" Tile
Movement -- Board
Movements o-- Movement
Player -- Movements

class Checkers {

  play()
  initPlayer(string color)
}


abstract class Player {
  string color

  {static} createPlayer(string color, string type, IO $io): Player
  getColor(): string
  
  {abstract} askForValidMovement(Movements $movement): Movement
}

class HumanPlayer {
  askForValidMovement(Movements $movements): Movement
}

class ComputerPlayer {
  askForValidMovement(Movements $movements): Movement
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
  evaluateIfIsKiller(Board $board): bool
  isKiller(): bool
  do(Board $board): void
}

class Movements {
  getSources(): array
  getAIMovement(): ?Movement
  getDestinationsFromSource(Tile $source): array
  getRandom(): Movement
}
@enduml
´´´