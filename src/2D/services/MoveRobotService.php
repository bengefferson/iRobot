<?php

namespace iRobot\TwoDimension\Service;

use InvalidArgumentException;
use Exception;
use iRobot\TwoDimension\Interfaces\PlaceRobotInterface;
use iRobot\TwoDimension\Interfaces\MoveRobotInterface;
use iRobot\TwoDimension\Service\RobotOrientationService;
use iRobot\TwoDimension\Config;

//This service handles the movement and turning of the robot
class MoveRobotService implements MoveRobotInterface
{
    //Properties place and orientation
    protected $place;

    public function __construct(PlaceRobotInterface $place)
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
                    $currentPosition['y'] += Config::DEFAULT_MOVEMENT_UNIT;
                    break;

                case Config::ORIENTATION_EAST:
                    $currentPosition['x'] += Config::DEFAULT_MOVEMENT_UNIT;
                    break;

                case Config::ORIENTATION_SOUTH:
                    $currentPosition['y'] -= Config::DEFAULT_MOVEMENT_UNIT;
                    break;

                case Config::ORIENTATION_WEST:
                    $currentPosition['x'] -= Config::DEFAULT_MOVEMENT_UNIT;
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

}