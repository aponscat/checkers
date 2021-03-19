<?php

namespace Omatech\Checkers;

class Checkers
{
    private IO $io;

    public function __construct()
    {
        $this->io = new IO();
    }

    public function play(): void
    {
        $playersArray=[];
        $playersArray[0] = $this->initPlayer('o');
        $playersArray[1] = $this->initPlayer('x');

        $turn = new Turn($playersArray);
        $board = new Board();
        $board->init($playersArray);

        do {
            $this->io->clearScreen();
            $this->io->printBoard($board);
            $currentPlayer=$turn->getCurrentPlayer();
            $movement = $currentPlayer->askForValidMovement($board->getAllPossibleMoves($currentPlayer->getColor()));
            $movement->do($board);
            $winnerColor = $board->getWinnerColor();
            if (!$winnerColor) {
                $turn->changeToNextPlayer();
            }
        } while (!$winnerColor);

        $this->io->clearScreen();
        echo "The winner is $winnerColor\n";
        $this->io->printBoard($board);
    }

    private function initPlayer(string $color): Player
    {
        $type = $this->io->askForTypeOfPlayer($color);
        $player = Player::createPlayer($color, $type, $this->io);
        return $player;
    }
}
