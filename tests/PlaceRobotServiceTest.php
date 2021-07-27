<?php
declare(strict_types=1);
namespace Test;
session_start();

use iRobot\TwoDimension\Service\PlaceRobotService;
use iRobot\TwoDimension\Board\SquareBoard;
use Test\TestCase;
use LogicException;
use InvalidArgumentException;

class PlaceRobotServiceTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();

        $this->board = $this->mock(SquareBoard::class);
        $this->place = $this->mock(PlaceRobotService::class, [$this->board]);
    }

    public function testIsPlacedReturnsFalseWhenNotPlaced()
    {
        $this->assertFalse($this->place->isPlaced());
    }

    public function testIsPlacedReturnsTrueWhenPlaced()
    {
        $this->place->placeOnBoard(1, 2,'north');
        $this->assertTrue($this->place->isPlaced());
    }

    public function testGetPositionThrowsExceptionWhenNotplaced()
    {
        $this->expectException(LogicException::class);
        $this->place->getPosition();
    }

    public function testPlaceRobotOnBoardThrowsExceptionWhenPlacedInInvalidPosition()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->place->placeOnBoard(1, 2,'northh');

        $this->expectException(InvalidArgumentException::class);
        $this->place->placeOnBoard(1, 2,'');

        $this->expectException(InvalidArgumentException::class);
        $this->place->placeOnBoard(-1, 2,'north');

        $this->expectException(InvalidArgumentException::class);
        $this->place->placeOnBoard(1, 2,'ea st');

        $this->expectException(InvalidArgumentException::class);
        $this->place->placeOnBoard(1, 8,'NORTH');
    }

    public function testGetPositionReturnsArrayWhenRobotIsPlaced()
    {
        $this->place->placeOnBoard(1, 2,'north');
        $this->assertIsArray($this->place->getPosition());
    }

    public function testPlaceRobotOnBoardActuallyPlacesTheRobotInTheParsedPosition()
    {
        $this->place->placeOnBoard();
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard(6, 6,'west ');
        $this->assertEquals($this->place->getPosition(),['x'=>6, 'y'=>6, 'orientation'=>'WEST']);

        $this->place->placeOnBoard(1, 2,'north');
        $this->assertEquals($this->place->getPosition(),['x'=>1, 'y'=>2, 'orientation'=>'NORTH']);

        $this->place->placeOnBoard(0, 6,'EAST');
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>6, 'orientation'=>'EAST']);

        $this->place->placeOnBoard(0, 0,' SoUth ');
        $this->assertEquals($this->place->getPosition(),['x'=>0, 'y'=>0, 'orientation'=>'SOUTH']);

    }


}