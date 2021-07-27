<?php

namespace iRobot\TwoDimension\Interfaces;
use iRobot\Interfaces\BoardInterface as BaseBoardInterface;

//Interface for two dimensional boards
interface BoardInterface extends BaseBoardInterface
{
    //All boards can check if a robot is within its bounds
    public function withinBounds(int $x, int $y):bool;
}
?>