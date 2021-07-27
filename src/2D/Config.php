<?php

namespace iRobot\TwoDimension;

use InvalidArgumentException;
use Exception;
use iRobot\TwoDimension\Service\CleanInputService;

class Config
{
    //Possible Methods and orientations that can be entered by the user
    const METHOD_PLACE  = 'PLACE';
    const METHOD_MOVE   = 'MOVE';
    const METHOD_LEFT   = 'LEFT';
    const METHOD_RIGHT  = 'RIGHT';
    const METHOD_REPORT = 'REPORT';

    const ORIENTATION_NORTH = 'NORTH';
    const ORIENTATION_EAST  = 'EAST';
    const ORIENTATION_SOUTH = 'SOUTH';
    const ORIENTATION_WEST  = 'WEST';


    //Default movement unit
    const DEFAULT_MOVEMENT_UNIT = 1;


    //Orientation Map (Defaults to right turn)
    const DEFAULT_ORIENTATION_MAP = [
        self::ORIENTATION_NORTH => self::ORIENTATION_EAST,
        self::ORIENTATION_EAST => self::ORIENTATION_SOUTH,
        self::ORIENTATION_SOUTH => self::ORIENTATION_WEST,
        self::ORIENTATION_WEST => self::ORIENTATION_NORTH,
    ];



    //Set the default board shspe and dimensions
    const DEFAULT_BOARD_SHAPE = 'square';

    //Example shapes and dimensions. Set preffered dimension

    //For square
    const BOARD_SHAPE_SQUARE = 'square';
    const BOARD_LENGTH_SQUARE = 6;

    //For rectangle
    const BOARD_SHAPE_RECTANGLE = 'rectangle';
    const BOARD_LENGTH_RECTANLE = 6;
    const BOARD_WIDTH_RECTANGLE = 4;


    //Array of permissible orientations
    public static function possibleOrientations() :array
    {
        return 
        [
            self::ORIENTATION_NORTH, 
            self::ORIENTATION_EAST, 
            self::ORIENTATION_SOUTH, 
            self::ORIENTATION_WEST,
        ];
    }


    //Array of permissible rotations
    public static function possibleRotations() :array
    {
        return 
        [
            self::METHOD_LEFT, 
            self::METHOD_RIGHT,
        ];
    }


    //Array of permissible commands
    public static function possibleCommands() : array
    {
        return 
        [
            self::METHOD_PLACE, 
            self::METHOD_MOVE, 
            self::METHOD_LEFT, 
            self::METHOD_RIGHT, 
            self::METHOD_REPORT,
        ];
    }


    //Get board length for default shape
    public static function getBoardLength() :int
    {
        $shape = self::DEFAULT_BOARD_SHAPE;
        return
        self::boardDimensions($shape)['length'];
    }


    //Get board width for default shape
    public static function getBoardWidth() :int
    {
        $shape = self::DEFAULT_BOARD_SHAPE;
        return
        self::boardDimensions($shape)['width'];
    }


    //Validate and get orientation map for right rotation (Default)
    public static function getOrientationMap() :array
    {
        if(! self::checkArraysEquality() ){
            throw new Exception("Invalid Orientation map. \n");
        }
        return self::DEFAULT_ORIENTATION_MAP;
    }
    

    //Get dimensions for chosen shape
    protected static function boardDimensions(string $shape) :array
    {
        $shape = CleanInputService::stringToLower($shape);
        $shapesDimensions =
        [
            self::BOARD_SHAPE_SQUARE => ['length' => self::BOARD_LENGTH_SQUARE, 'width' => self::BOARD_LENGTH_SQUARE],
            self::BOARD_SHAPE_RECTANGLE => ['length' => self::BOARD_LENGTH_RECTANLE, 'width' => self::BOARD_WIDTH_RECTANGLE],
        ];
        if( !array_key_exists($shape,$shapesDimensions))
        {
            throw new InvalidArgumentException("Shape $shape needs to be configured in config file.\n");
        }
        return $shapesDimensions[$shape];
    }


    //Helper function to check if 3 arrays are equal
    private static function checkArraysEquality() :bool
    {
        $orientations = self::possibleOrientations();
        sort($orientations);
        $orientationMapKeys = array_keys(self::DEFAULT_ORIENTATION_MAP);
        sort($orientationMapKeys);
        $orientationMapValues = array_values(self::DEFAULT_ORIENTATION_MAP);
        sort($orientationMapValues);
        $logic = ($orientations == $orientationMapKeys)  && ($orientations == $orientationMapValues);
        return $logic;
    }

}