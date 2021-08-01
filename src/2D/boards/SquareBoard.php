<?php

namespace iRobot\TwoDimension\Board;

use InvalidArgumentException;
use iRobot\TwoDimension\Config;
use iRobot\TwoDimension\Interfaces\BoardInterface;

//This class handles logic for square boards
class SquareBoard implements BoardInterface
{

    public function __construct()
    {
        $this->width = Config::getBoardWidth();
        $this->height = Config::getBoardLength();
    }

    //Checks if the coordinates of the robot are with the board's bounds
    public function withinBounds(int $x, int $y) :bool
    {
        if(!((0 <= $x && $x <= $this->width) && (0 <= $y && $y <= $this->height))){
            throw new InvalidArgumentException(print_r("Coordinates $x and $y need to be within the board's boundaries- $this->width,$this->height.\n"));
        }
        return True;
    }

}