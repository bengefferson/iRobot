<?php
namespace iRobot\TwoDimension\Service;
session_start();

use InvalidArgumentException;
use iRobot\TwoDimension\Config;
use iRobot\TwoDimension\Service\CleanInputService;

//Service to handle logic that deal with orientation after rotation
class RobotOrientationService
{

    public function __construct()
    {

    }

    //Validates if an orientation is permissible as specified in config class
    public static function isPermissibleOrientation(string $orientation) :bool
    {
        $orientation = CleanInputService::trimmedAndCapitalized($orientation);
        if (! in_array($orientation, self::getOrientations())){
            throw new InvalidArgumentException(print_r("Orientation $orientation is not a valid orientation.\n"));
        }
        return True;
    }

    //Validates if a rotation is permissible as specified in config class
    public static function isPermissibleRotation(string $rotation) :bool
    {
        $rotation = CleanInputService::trimmedAndCapitalized($rotation);
        if (! in_array($rotation, self::getRotations())){
            throw new InvalidArgumentException(print_r("Rotations $rotation is not a valid rotations.\n"));
        }
        return True;
    }

    //Returns the new orientation after a robot has been rotated in a particular direction
    public static function orientationAfterRotation(string $rotation, string $orientation) :string
    {
        $rotation = CleanInputService::trimmedAndCapitalized($rotation);
        $orientation = CleanInputService::trimmedAndCapitalized($orientation);
        if (self::isPermissibleRotation($rotation) && self::isPermissibleOrientation($orientation)){
            if (isset($_SESSION["orientationMap$rotation"])){
                return $_SESSION["orientationMap$rotation"][$orientation];
            }
            $newOrientation = self::orientationMap($rotation)[$orientation];
            return $newOrientation;
        }
    }

    //Returns the orientation map W.R.T the rotation parsed
    protected static function orientationMap(string $rotation) :array
    {
        $rotation = CleanInputService::trimmedAndCapitalized($rotation);
        if (self::isPermissibleRotation($rotation)){
            $orientations = self::getOrientations();
            //defaults  to right
            $orientationMap = Config::getOrientationMap();
            if ($rotation == Config::METHOD_RIGHT){
                $_SESSION['orientationMapRIGHT'] = $orientationMap;
                return $orientationMap;
            }elseif ($rotation == Config::METHOD_LEFT){
                $_SESSION['orientationMapLEFT'] = array_flip($orientationMap);
                return array_flip($orientationMap);
            }
        }

    }

    //Get permissible orientations from config class
    protected static function getOrientations() :array
    {
        return Config::possibleOrientations();
    }

    //Get permissible rotations from Config class
    protected static function getRotations() :array
    {
        return Config::possibleRotations();
    }


}