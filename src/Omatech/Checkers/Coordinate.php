<?php
namespace Omatech\Checkers;

class Coordinate
{
    private int $row;
    private int $column;

    public function __construct(int $row, int $column)
    {
        $this->row=$row;
        $this->column=$column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function __toString(): string
    {
        return $this->getRow().'-'.$this->getColumn();
    }
}
