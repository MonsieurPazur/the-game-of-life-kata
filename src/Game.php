<?php

/**
 * Handles all main functionalities within Game of Life.
 */

namespace App;

/**
 * Class Game
 * @package App
 */
class Game
{
    /**
     * @var int cell that is alive
     */
    const CELL_ALIVE = 1;

    /**
     * @var int cell that is dead
     */
    const CELL_DEAD = 0;

    /**
     * @var array game grid, consisting of dead or alive cells
     */
    private $grid;

    /**
     * Game constructor.
     * @param array $grid
     */
    public function __construct(array $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Goes into next step of the game.
     */
    public function step(): void
    {
        for ($i = 0; $i < count($this->grid); $i++) {
            for ($j = 0; $j < count($this->grid[0]); $j++) {
                if (self::CELL_ALIVE === $this->grid[$i][$j]) {
                    $this->grid[$i][$j] = self::CELL_DEAD;
                }
            }
        }
    }

    /**
     * Returns result Game matrix.
     *
     * @return array result Game two-dimensional array
     */
    public function get(): array
    {
        return $this->grid;
    }
}
