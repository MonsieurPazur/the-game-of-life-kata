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
     * @var Grid $grid Game grid, consisting of dead or alive cells
     */
    private $grid;

    /**
     * Game constructor.
     * @param array $grid
     */
    public function __construct(array $grid)
    {
        $this->grid = new Grid($grid);
    }

    /**
     * Goes into next step of the game.
     */
    public function step(): void
    {
        $this->grid->update();
    }

    /**
     * Returns result Game matrix.
     *
     * @return array result Game two-dimensional array
     */
    public function get(): array
    {
        return $this->grid->get();
    }
}
