<?php

/**
 * Simple class for holding internal information for grid cell.
 */

namespace App;

/**
 * Class Cell
 * @package App
 */
class Cell
{
    /**
     * @var int Cell that is alive
     */
    public const ALIVE = 1;

    /**
     * @var int Cell that is dead
     */
    public const DEAD = 0;

    /**
     * @var int $state state of Cell
     */
    private $state;

    /**
     * Cell constructor.
     *
     * @param int $state
     */
    public function __construct(int $state)
    {
        $this->state = $state;
    }

    /**
     * Checks whether this cell is alive.
     *
     * @return bool true if this cell is alive
     */
    public function isAlive(): bool
    {
        return $this->state === self::ALIVE;
    }

    /**
     * Kills this cell, sets it's internal state to DEAD.
     */
    public function kill(): void
    {
        $this->state = self::DEAD;
    }

    /**
     * Makes this cell alive again, sets it's internal state to ALIVE.
     */
    public function ressurect(): void
    {
        $this->state = self::ALIVE;
    }

    /**
     * Gets current state of a cell. Used for creating fallback to regular array.
     *
     * @return int current state (DEAD or ALIVE) of this cell
     */
    public function getState(): int
    {
        return $this->state;
    }
}
