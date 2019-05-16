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
        $game = new Game();
        $game->step();
        $this->assertTrue(true);
    }
}
