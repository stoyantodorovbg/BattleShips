<?php

namespace App\Services;

use App\Services\Interfaces\GameServiceInterface;
use App\Services\Interfaces\GridServiceInterface;
use App\Services\Interfaces\ShotServiceInterface;

class GameService implements GameServiceInterface
{
    /**
     * Perform the logic for the game finishing
     *
     * @param string $gameName
     * @return int
     */
    public function finishGame(string $gameName = 'battle_ships'): int
    {
        $shotService = resolve(ShotServiceInterface::class);
        $shotSessionKey = $shotService->getShotsKey($gameName);

        $gridService = resolve(GridServiceInterface::class);
        $gridSessionKey = $gridService->getGridKey($gameName);

        $shotCount = session($shotSessionKey);

        session()->forget($shotSessionKey);
        session()->forget($gridSessionKey);

        return $shotCount;
    }
}
