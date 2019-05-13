<?php

namespace App\Services;

use App\Services\Interfaces\GridServiceInterface;
use App\Services\Interfaces\ShotServiceInterface;

class ShotService implements ShotServiceInterface
{
    /**
     * Mark a cell from the grid as hit
     *
     * @param $row
     * @param $col
     * @param string $gridKey
     * @return bool
     */
    public function shootCell($row, $col, string $gridKey = 'grid_battle_ships'): bool
    {
        $gridService = resolve(GridServiceInterface::class);

        $grid = $gridService->getGrid($gridKey);

        $grid[$gridKey][$row][$col]['is_hit'] = true;

        $gridService->updateGrid($grid, $gridKey);
    }
}
