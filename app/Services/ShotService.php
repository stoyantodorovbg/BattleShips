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
     * @return array
     */
    public function shootCell(array $coords, string $gameName = 'battle_ships'): array
    {
        $gridService = resolve(GridServiceInterface::class);

        $grid = $gridService->getGrid($gameName);

        $grid[$coords['row']][$coords['col']]['is_hit'] = true;

        $gridService->updateGrid($grid, $gameName);

        $this->countShots();

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

    /**
     * Reset the shot count
     *
     * @param string $gameName
     */
    public function resetShotCount(string $gameName = 'battle_ships'): void
    {
        $shotSessionKey = $this->getShotsKey($gameName);

        if(session()->has($shotSessionKey)) {
            session([$shotSessionKey => 0]);
        }
    }

    /**
     * Set an initial shot count
     *
     * @param string $gameName
     */
    public function setShotCount(string $gameName = 'battle_ships'): void
    {
        $shotSessionKey = $this->getShotsKey($gameName);

        session([$shotSessionKey => 0]);
    }
}
