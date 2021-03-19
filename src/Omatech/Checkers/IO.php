<?php
namespace Omatech\Checkers;

class IO
{
    public function askForTypeOfPlayer(string $color): string
    {
        $valid=false;
        do {
            $input=$this->getInput("Select Human or Computer for player $color [C|h]:");
            if ($input==='') {
                $input='c';
            }
            $input=strtolower($input);
            if ($input=='c' || $input=='h') {
                $valid=true;
            }
        } while (!$valid);
        return $input;
    }

    public function getInput(string $message): string
    {
        return readline($message);
    }

    public function printBoard(Board $board): void
    {
        echo "Current board is:\n";
        echo $board;
    }

    public function clearScreen(): void
    {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
    }
}
