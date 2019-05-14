<?php

namespace App\Services;

use App\Services\Interfaces\GridServiceInterface;
use App\Services\Interfaces\ShipServiceInterface;

class GridService implements GridServiceInterface
{
    /**
     * Create an grid and store in into the session
     *
     * @param array $shipData
     * @param int $rows
     * @param int $cols
     * @param string $gameName
     * @return array
     */
    public function createGrid(array $shipData, int $rows = 10, int $cols = 10, string $gameName = 'battle_ships'): array
    {
        $gridData = $this->prepareGridData($rows, $cols, $gameName);

        $shipService = resolve(ShipServiceInterface::class);

        session($gridData);

        $shipService->addShips($gridData[$this->getGridKey($gameName)], $shipData);

        return $gridData;
    }

    /**
     * Get the grid from the session
     *
     * @param string $gameName
     * @return array
     */
    public function getGrid(string $gameName = 'battle_ships'): array
    {
        $gridSessionKey = $this->getGridKey($gameName);

        return session($gridSessionKey);
    }

    /**
     * Update the grid stored into the session
     *
     * @param array $grid
     * @param string $gameName
     * @return bool
     */
    public function updateGrid(array $grid, string $gameName = 'battle_ships'): bool
    {
        $gridSessionKey = $this->getGridKey($gameName);

        $this->removeGrid($gridSessionKey);

        session([$gridSessionKey => $grid]);

        return true;
    }

    /**
     * Remove the grid from the session
     *
     * @param string $gameName
     * @return bool
     */
    public function removeGrid(string $gameName = 'battle_ships'): bool
    {
        $gridSessionKey = $this->getGridKey($gameName);

        session()->forget($gridSessionKey);

        return true;
    }

    /**
     * Prepare a new grid
     *
     * @param int $rows
     * @param int $cols
     * @param string $gameName
     * @return array
     */
    protected function prepareGridData(int $rows, int $cols, string $gameName): array
    {
        $gridSessionKey = $this->getGridKey($gameName);

        $grid = [
            $gridSessionKey => [],
        ];

        for ($row = 1; $row <= $rows; $row++) {
            for ($col= 1; $col <= $cols; $col++) {
                $grid[$gridSessionKey][$row][$col] = [
                    'is_empty' => true,
                    'is_hit' => false,
                ];
            }
        }

        return $grid;
    }

    /**
     * Get the session key for the grid
     *
     * @param string $gameName
     * @return string
     */
    public function getGridKey(string $gameName = 'battle_ships'): string
    {
        return $gameName . '_grid';
    }
}
