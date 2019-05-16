<?php

/**
 * Basic test suite for Game of Life interface.
 */

namespace Test;

use App\Game;
use PHPUnit\Framework\TestCase;

/**
 * Class GameOfLifeTest
 * @package Test
 */
class GameOfLifeTest extends TestCase
{

    /**
     * Tests basic game functionalities.
     */
    public function testGame()
    {
        $grid = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ];
        $game = new Game($grid);
        $game->step();
        $this->assertIsArray($game->get());
        $this->assertEquals($grid, $game->get());
    }
}
