<?php

namespace iRobot\TwoDimension\Service;

use InvalidArgumentException;
use Exception;
use iRobot\TwoDimension\Service\PlaceRobotService;
use iRobot\TwoDimension\Service\RobotOrientationService;
use iRobot\TwoDimension\Config;

//This service handles the movement and turning of the robot
class MoveRobotService
{
    //Properties place and orientation
    protected $place;

    public function __construct(PlaceRobotService $place)
    {
        $this->place = $place;
    }
    

    //Moves the placed robot one unit forward W.R.T its current orientation
    public function moveForwardWRTOrientation() :void
    {
        if($this->place->isPlaced()){
            $currentPosition = $this->place->getPosition();
            // Determine new position based on current direction
            switch ($currentPosition['orientation']) {
                case Config::ORIENTATION_NORTH:
                    $currentPosition['y'] += $this->getMovementUnit();
                    break;

                case Config::ORIENTATION_EAST:
                    $currentPosition['x'] += $this->getMovementUnit();
                    break;

                case Config::ORIENTATION_SOUTH:
                    $currentPosition['y'] -= $this->getMovementUnit();
                    break;

                case Config::ORIENTATION_WEST:
                    $currentPosition['x'] -= $this->getMovementUnit();
                    break;
            }
            $newPosition = ['x'=>$currentPosition['x'], 'y'=>$currentPosition['y'], 'orientation'=>$currentPosition['orientation']];
            $this->place->placeOnBoard($newPosition['x'],$newPosition['y'],$newPosition['orientation']);
        }

    }

    //Turns the placed robot to the desired rotation W.R.T its current orientation
    public function rotate(string $rotation) :void
    {
        $orientation = $this->place->getPosition()['orientation'];
        $newOrientation = RobotOrientationService::orientationAfterRotation($rotation,$orientation);
        $x = $this->place->getPosition()['x'];
        $y = $this->place->getPosition()['y'];
        $this->place->placeOnBoard($x,$y,$newOrientation);
    }

    //Gets movement unit from the config class
    protected function getMovementUnit() :int
    {
        return Config::DEFAULT_MOVEMENT_UNIT;
    }
}