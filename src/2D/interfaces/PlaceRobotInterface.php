<?php

namespace iRobot\TwoDimension\Interfaces;

//Interface for two dimensional boards
interface PlaceRobotInterface
{
    // Place robot on board with chosen coordinates and orientation.
    public function placeOnBoard(int $x, int $y, string $orientation) :void ;

    //Check if robot is placed
    public function isPlaced() :bool ;

    //Get the current position of the robot
    public function getPosition() :array ;
}
?>