<?php

namespace iRobot\TwoDimension\Interfaces;

//Interface for two dimensional boards
interface MoveRobotInterface
{
    //Moves the placed robot one unit forward W.R.T its current orientation
    public function moveForwardWRTOrientation() :void ;

    //Turns the placed robot to the desired rotation W.R.T its current orientation
    public function rotate(string $rotation) :void ;
}
?>