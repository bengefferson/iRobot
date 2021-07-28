<?php

namespace iRobot\TwoDimension;

use InvalidArgumentException;
use Exception;
use iRobot\TwoDimension\Service\PlaceRobotService;
use iRobot\TwoDimension\Service\RobotOrientationService;
use iRobot\TwoDimension\Service\MoveRobotService;
use iRobot\TwoDimension\Config;
use iRobot\Interfaces\RobotInterface;

//This class executes a command given to the robot
class Robot implements RobotInterface
{
    protected $place;
    protected $move;


    public function __construct(PlaceRobotService $place, MoveRobotService $move)
    {
        $this->place = $place;
        $this->move = $move;
    }
    
    //Gets possible commands from the Config class
    public function getCommands(): array
    {
        return Config::possibleCommands();
    }


    // Executes the commands W.R.T the placed robot
    public function execute(array $command) :void
    {
        $flag = False;
        if(count($command) == 2){
            $x = $command[1][0];
            $y = $command[1][1];
            $orientation = $command[1][2];
        }else{
            $flag = True;
            $x = 0;
            $y = 0;
            $orientation = Config::ORIENTATION_NORTH;
        }
        if(! in_array($command[0],$this->getCommands())){
            throw new InvalidArgumentException("Command $command[0] is not a valid command.\n");
        }
        switch ($command[0]) {
            case Config::METHOD_PLACE:
                if ($flag){
                    echo "Warning: Default values for X,Y and Orientation used, because no valid argument was parsed.\n";
                }
                $this->place->placeOnBoard($x, $y, $orientation);
                break;

            case Config::METHOD_MOVE:
                $this->move->moveForwardWRTOrientation();
                break;

            case Config::METHOD_LEFT:
                $this->move->rotate($command[0]);
                break;

            case Config::METHOD_RIGHT:
                $this->move->rotate($command[0]);
                break;

            case Config::METHOD_REPORT:
                $x = $this->place->getPosition()['x'];
                $y = $this->place->getPosition()['y'];
                $orientation = $this->place->getPosition()['orientation'];
                print_r("Output: $x, $y, $orientation \n") ;
                break;
        }
    }
}