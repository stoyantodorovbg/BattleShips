<?php

namespace App\Services;

use App\Services\Interfaces\GridServiceInterface;
use App\Services\Interfaces\ShotServiceInterface;

class ShotService implements ShotServiceInterface
{
    /**
     * Mark a cell from the grid as hit
     *
     * @param array $coords
     * @param string $gameName
     * @return bool
     */
    public function shootCell(array $coords, string $gameName = 'battle_ships'): array
    {
        $gridService = resolve(GridServiceInterface::class);
        $gridSessionKey = $gridService->getShotsKey($gameName);

        $grid = $gridService->getGrid($gridSessionKey);

        $grid[$gridSessionKey][$coords['row']][$coords['col']]['is_hit'] = true;

        $gridService->updateGrid($grid, $gridSessionKey);

        return $grid;
    }

    /**
     * Update the shot count in the session
     *
     * @param string $gameName
     * @return int
     */
    public function countShots(string $gameName = 'battle_ships'): int
    {
        $shotSessionKey = $this->getShotsKey($gameName);

        if(! session()->has($shotSessionKey)) {
            session([$shotSessionKey => 1]);

            return 1;
        }

        $shotsCount = session($shotSessionKey);
        $shotsCount++;

        session([$shotSessionKey => $shotsCount]);

        return $shotsCount;
    }

    /**
     * Get the shots count
     *
     * @param string $gameName
     * @return int
     */
    public function getShotsCount(string $gameName = 'battle_ships'): int
    {
        $shotSessionKey = $this->getShotsKey($gameName);

        return session($shotSessionKey);
    }

    /**
     * Get the session key for the shots count
     *
     * @param string $gameName
     * @return string
     */
    public function getShotsKey(string $gameName = 'battle_ships'): string
    {
        return $gameName . '_shots';
    }
}
