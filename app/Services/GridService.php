<?php

namespace App\Services;

use App\Services\Interfaces\GridServiceInterface;

class GridService implements GridServiceInterface
{
    /**
     * Create an grid and store in into the session
     *
     * @param int $rows
     * @param int $cols
     * @return array
     */
    public function createGrid(int $rows = 10, int $cols = 10): array
    {
        $gridData = $this->prepareGridData($rows, $cols);

        session($gridData);

        return $gridData;
    }

    /**
     * Get the grid from the session
     *
     * @param string $gridKey
     * @return array
     */
    public function getGrid(string $gridKey = 'grid_battle_ships'): array
    {
        return session($gridKey);
    }

    /**
     * Update the grid stored into the session
     *
     * @param array $grid
     * @param string $gridKey
     * @return bool
     */
    public function updateGrid(array $grid, string $gridKey = 'grid_battle_ships'): bool
    {
        $this->removeGrid($gridKey);

        session([$gridKey => $grid]);

        return true;
    }

    /**
     * Remove the grid from the session
     *
     * @param string $gridKey
     * @return bool
     */
    public function removeGrid(string $gridKey = 'grid_battle_ships'): bool
    {
        session()->forget($gridKey);

        return true;
    }

    /**
     * Prepare a new grid
     *
     * @param int $rows
     * @param int $cols
     * @return array
     */
    protected function prepareGridData(int $rows, int $cols): array
    {
        $grid = [
            'grid_battle_ships' => [],
        ];

        for ($row = 1; $row <= $rows; $row++) {
            $grid['grid_battle_ships'][] = [];

            for ($col= 1; $col <= $cols; $col++) {
                $grid['grid_battle_ships'][$row][] = [
                    'is_empty' => true,
                    'is_hit' => false,
                ];
            }
        }

        return $grid;
    }
}
