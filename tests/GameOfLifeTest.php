<?php

/**
 * Basic test suite for Game of Life interface.
 */

namespace Test;

use App\Game;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class GameOfLifeTest
 * @package Test
 */
class GameOfLifeTest extends TestCase
{

    /**
     * Tests basic game functionalities.
     *
     * @dataProvider gridProvider
     *
     * @param array $input initial grid
     * @param int $steps amount of steps to apply
     * @param array $expected expected result grid
     */
    public function testGame(array $input, int $steps, array $expected)
    {
        $game = new Game($input);
        for ($i = 0; $i < $steps; $i++) {
            $game->step();
        }
        $this->assertEquals($expected, $game->get());
    }

    /**
     * Grid data provider.
     * Consists of initial grid, number of steps, and expected result grid.
     *
     * @return Generator
     */
    public function gridProvider()
    {
        yield '3x3 all dead' => [
            'input' => [
                [0, 0, 0],
                [0, 0, 0],
                [0, 0, 0]
            ],
            'steps' => 0,
            'expected' => [
                [0, 0, 0],
                [0, 0, 0],
                [0, 0, 0]
            ]
        ];
        yield '3x3 one alive' => [
            'input' => [
                [0, 0, 0],
                [0, 1, 0],
                [0, 0, 0]
            ],
            'steps' => 1,
            'expected' => [
                [0, 0, 0],
                [0, 0, 0],
                [0, 0, 0]
            ]
        ];
        yield '2x2 still life' => [
            'input' => [
                [1, 1],
                [1, 1]
            ],
            'steps' => 5,
            'expected' => [
                [1, 1],
                [1, 1]
            ]
        ];
    }
}
