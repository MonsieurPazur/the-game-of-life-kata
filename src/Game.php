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
     * @var array neighbours matrix
     */
    private $neighbours;

    /**
     * Game constructor.
     * @param array $grid
     */
    public function __construct(array $grid)
    {
        $this->grid = $grid;
        $this->initNeighbours();
    }

    /**
     * Goes into next step of the game.
     */
    public function step(): void
    {
        $this->updateNeighbours();
        $this->updateGrid();
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

    /**
     * Initializes neighbours matrix.
     */
    private function initNeighbours(): void
    {
        $this->neighbours = [];
        for ($i = 0; $i < count($this->grid); $i++) {
            for ($j = 0; $j < count($this->grid[0]); $j++) {
                $this->neighbours[$i][$j] = 0;
            }
        }
    }

    /**
     * Gets number of neighbours for a cell of given coordinates.
     *
     * @param int $i y coordinate for grid
     * @param int $j x coordinate for grid
     *
     * @return int number of alive neighbours
     */
    private function getNeighboursCount(int $i, int $j): int
    {
        $neighbours = 0;
        for ($y = $i - 1; $y <= $i + 1; $y++) {
            for ($x = $j - 1; $x <= $j + 1; $x++) {
                if (isset($this->grid[$y][$x])
                    && self::CELL_ALIVE === $this->grid[$y][$x]
                    && !($x == $j && $y == $i)
                ) {
                    $neighbours++;
                }
            }
        }
        return $neighbours;
    }

    /**
     * Updates neighbours matrix based on current grid state.
     */
    private function updateNeighbours(): void
    {
        for ($i = 0; $i < count($this->grid); $i++) {
            for ($j = 0; $j < count($this->grid[0]); $j++) {
                $this->neighbours[$i][$j] = $this->getNeighboursCount($i, $j);
            }
        }
    }

    /**
     * Updates grid based on neighbours matrix.
     */
    private function updateGrid(): void
    {
        for ($i = 0; $i < count($this->grid); $i++) {
            for ($j = 0; $j < count($this->grid[0]); $j++) {
                $this->applyRules($i, $j);
            }
        }
    }

    /**
     * Applies game rules to cell at given coordinates.
     *
     * @param int $i y coordinate for grid
     * @param int $j x coordinate for grid
     */
    private function applyRules(int $i, int $j): void
    {
        if (self::CELL_ALIVE === $this->grid[$i][$j]) {
            // 1. Any live cell with fewer than two live neighbours dies, as if by underpopulation.
            if ($this->neighbours[$i][$j] < 2) {
                $this->grid[$i][$j] = self::CELL_DEAD;
            }
            // 2. Any live cell with two or three live neighbours lives on to the next generation.
            if (2 === $this->neighbours[$i][$j] || 3 === $this->neighbours[$i][$j]) {
                $this->grid[$i][$j] = self::CELL_ALIVE;
            }
            // 3. Any live cell with more than three live neighbours dies, as if by overpopulation.
            if ($this->neighbours[$i][$j] > 3) {
                $this->grid[$i][$j] = self::CELL_DEAD;
            }
        } else {
            // 4. Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
            if (3 === $this->neighbours[$i][$j]) {
                $this->grid[$i][$j] = self::CELL_ALIVE;
            }
        }
    }
}
