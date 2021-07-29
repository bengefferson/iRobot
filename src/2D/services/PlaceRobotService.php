<?php

namespace iRobot\TwoDimension\Service;

use InvalidArgumentException;
use LogicException;
use iRobot\TwoDimension\Service\RobotOrientationService;
use iRobot\TwoDimension\Service\CleanInputService;
use iRobot\TwoDimension\Config;
use iRobot\TwoDimension\Interfaces\BoardInterface;

//This service is used to place a robot at a particular coordinate and direction and get the robots position afterwards
class PlaceRobotService
{
    //Properties used for placong the robot

    //board
    protected $board;
    //The coordinates
    protected $x;
    protected $y;
    //The Orientation
    protected $orientation;

    public function __construct(BoardInterface $board)
    {
        $this->board = $board;
        $this->x = null;
        $this->y = null;
        $this->orientation = null;
    }

    // Place robot on board with chosen coordinates and orientation. Defaults to 0,0,NORTH
    public function placeOnBoard(int $x=0, int $y=0, string $orientation = Config::ORIENTATION_NORTH) :void
    {
        $orientation = CleanInputService::trimmedAndCapitalized($orientation);
        if ($this->board->withinBounds($x,$y) && RobotOrientationService::isPermissibleOrientation($orientation)) {
            // Set robot position and orientation
            $this->x = $x;
            $this->y = $y;
            $this->orientation = $orientation;
        }
        
    }

    //Check if robot is placed
    public function isPlaced() :bool
    {
        if(! is_null($this->x) && ! is_null($this->y) && ! is_null($this->orientation)){
            return True;
        }else{
            return False;
        }
    }

    //Get the current position of the robot
    public function getPosition() :array
    {
        if(! $this->isPlaced()){
            throw new InvalidArgumentException(print_r("The robot needs to be placed first!\n"));
        }
        return ['x'=>$this->x, 'y'=>$this->y, 'orientation'=>$this->orientation];
    }

}