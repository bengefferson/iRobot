<?php

namespace iRobot\TwoDimension\Service;

use InvalidArgumentException;
use Exception;

//This service handles the cleaning of inputs that will be parsed into other 2D functions
class CleanInputService
{
    //Trims white spaces from input
    public static function trimWhiteSpace(string $input) :string
    {
        return trim($input);
    }

    //Capitalizes input
    public static function stringToUpper(string $input) :string
    {
        return strtoupper($input);
    }

    //Trims and capitalizes input
    public static function trimmedAndCapitalized(string $input) :string
    {
        return self::stringToUpper(self::trimWhiteSpace($input));
    }

    //Converts input to lower case
    public static function stringToLower(string $input) :string
    {
        return strtolower($input);
    }

    //Converts command string into desired array
    public static function parseCommand(string $input) :array
    {
        $separator1 =' ';
        $separator2 =',';
        $arrayCommand = explode($separator1, self::trimWhiteSpace($input));

        if (count($arrayCommand)== 2){
            $arrayCoordinates = explode($separator2, self::trimWhiteSpace($arrayCommand[1]));
            if (count($arrayCoordinates)== 3){
                $x = $arrayCoordinates[0];
                $y = $arrayCoordinates[1];
                $orientation = $arrayCoordinates[2];
                if (! is_numeric($x)){
                    throw new InvalidArgumentException(print_r("The coordinate $x must be an integer.\n"));
                }
                if (! is_numeric($y)){
                    throw new InvalidArgumentException(print_r("The coordinate $y must be an integer.\n"));
                }
                if (! is_string($orientation)){
                    throw new InvalidArgumentException(print_r("$orientation must be an integer.\n"));
                }
                $arrayCoordinates[0] = intval($x);
                $arrayCoordinates[1] = intval($y);
                $arrayCoordinates[2] = self::trimmedAndCapitalized($orientation);
                $arrayCommand[1] = $arrayCoordinates;
            }else{
                throw new Exception(print_r("Invalid set of coordinates and orientations \n"));
            }
        }
        $arrayCommand[0] = self::trimmedAndCapitalized($arrayCommand[0]);
        
        return $arrayCommand;
    }

}