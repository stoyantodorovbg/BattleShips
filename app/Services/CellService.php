<?php


namespace App\Services;


use App\Services\Interfaces\CellServiceInterface;
use App\Services\Interfaces\GridServiceInterface;

class CellService implements CellServiceInterface
{
    public function isCellEmpty(array $cellCoords, array $grid = [], string $gameName = 'battle_ships'): bool
    {
        if(! $grid) {
            $gridService = resolve(GridServiceInterface::class);

            $grid = $gridService->getGrid($gameName);
        }

        return $grid[$cellCoords['row']][$cellCoords['col']]['is_empty'];
    }

    /**
     * Check if a cell has been hit
     *
     * @param array $cellCoords
     * @param string $gameName
     * @return bool
     */
    public function hasCellHit(array $cellCoords, string $gameName = 'battle_ships'): bool
    {
        $gridService = resolve(GridServiceInterface::class);

        $grid = $gridService->getGrid($gameName);

        return $grid[$cellCoords['row']][$cellCoords['col']]['is_hit'];
    }
}