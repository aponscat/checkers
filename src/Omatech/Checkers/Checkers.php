<?php

namespace Omatech\Checkers;

class Checkers
{
    private Board $board;
    private Turn $turn;
    private IO $io;

    public function __construct()
    {
        $this->board = new Board();
        $this->io = new IO();
    }

    public function play(): void
    {
        $playersArray=[];
        $playersArray[0] = $this->initPlayer('o');
        $playersArray[1] = $this->initPlayer('x');

        $this->turn = new Turn($playersArray);
        $this->board->init($playersArray);

        do {
            $this->io->clearScreen();
            $this->io->printBoard($this->board);
            $movement = $this->turn->getCurrentPlayer()->askForValidMovement($this->board);
            $movement->do($this->board);
            $winnerColor = $this->board->getWinnerColor();
            if (!$winnerColor) {
                $this->turn->changeToNextPlayer();
            }
        } while (!$winnerColor);

        $this->io->clearScreen();
        echo "The winner is $winnerColor\n";
        $this->io->printBoard($this->board);
    }

    public function initPlayer(string $color): Player
    {
        $type = $this->io->askForTypeOfPlayer($color);
        $player = Player::createPlayer($color, $type);
        return $player;
    }
}
