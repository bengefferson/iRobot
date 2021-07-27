<?php
declare(strict_types=1);

namespace Test;

use iRobot\TwoDimension\Board\SquareBoard;
use Test\TestCase;
use InvalidArgumentException;

class SquareBoardTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();

        $this->board = $this->mock(SquareBoard::class);

    }

    public function testCoordinatesWithinBounds()
    {
        $this->assertTrue($this->board->withinBounds(0, 0));
        $this->assertTrue($this->board->withinBounds(2, 2));
        $this->assertTrue($this->board->withinBounds(0, 6));
        $this->assertTrue($this->board->withinBounds(6, 0));
        $this->assertTrue($this->board->withinBounds(6, 6));
    }


    public function testCoordinateXThrowsExceptionWhenOutsideBoardBounds()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->board->withinBounds(-1, 3);
    }
    public function testCoordinateYThrowsExceptionWhenOutsideBoardBounds()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->board->withinBounds(3, 7);
    }
    public function testCoordinateXAndYThrowExceptionWhenOutsideBoardBounds()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->board->withinBounds(-1, 7);
    }
}