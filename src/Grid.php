<?php
/**
 * Two dimensional matrix, where the Game takes place.
 */

namespace App;

/**
 * Class Grid
 * @package App
 */
class Grid
{
    /**
     * @var array $grid two dimensional matrix
     */
    private $grid;

    /**
     * @var array $neighbours neighbours matrix
     */
    private $neighbours;

    /**
     * Grid constructor.
     *
     * @param array $initial initial state of game
     */
    public function __construct(array $initial)
    {
        $this->initGrid($initial);
    }

    /**
     * Returns internal grid matrix in a raw form (so just a 2d matrix of 0's and 1's).
     *
     * @return array two dimensional matrix
     */
    public function get(): array
    {
        $rawGrid = [];
        for ($i = 0; $i < count($this->grid); $i++) {
            for ($j = 0; $j < count($this->grid[0]); $j++) {
                $rawGrid[$i][$j] = $this->grid[$i][$j]->getState();
            }
        }
        return $rawGrid;
    }

    /**
     * Wraps updating neighbour matrix and updating grid cells in one method.
     * Those two updates are dependant on each other and must be run in order.
     */
    public function update(): void
    {
        $this->updateNeighbours();
        $this->updateGrid();
    }

    /**
     * Initializes grid with Cells, based on initial values.
     * Also initializes neighbour matrix with 0's.
     *
     * @param array $initial two dimensional array of 0's and 1's
     */
    private function initGrid(array $initial): void
    {
        for ($i = 0; $i < count($initial); $i++) {
            for ($j = 0; $j < count($initial[0]); $j++) {
                $this->neighbours[$i][$j] = 0;
                $this->grid[$i][$j] = new Cell($initial[$i][$j]);
            }
        }
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
                    && $this->grid[$y][$x]->isAlive()
                    && !($x == $j && $y == $i)
                ) {
                    $neighbours++;
                }
            }
        }
        return $neighbours;
    }

    /**
     * Applies game rules to cell at given coordinates.
     *
     * @param int $i y coordinate for grid
     * @param int $j x coordinate for grid
     */
    private function applyRules(int $i, int $j): void
    {
        if ($this->grid[$i][$j]->isAlive()) {
            // 1. Any live cell with fewer than two live neighbours dies, as if by underpopulation.
            if ($this->neighbours[$i][$j] < 2) {
                $this->grid[$i][$j]->kill();
            }
            // 2. Any live cell with two or three live neighbours lives on to the next generation.
            if (2 === $this->neighbours[$i][$j] || 3 === $this->neighbours[$i][$j]) {
                $this->grid[$i][$j]->ressurect();
            }
            // 3. Any live cell with more than three live neighbours dies, as if by overpopulation.
            if ($this->neighbours[$i][$j] > 3) {
                $this->grid[$i][$j]->kill();
            }
        } else {
            // 4. Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
            if (3 === $this->neighbours[$i][$j]) {
                $this->grid[$i][$j]->ressurect();
            }
        }
    }
}
