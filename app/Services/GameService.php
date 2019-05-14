<?php

namespace App\Services;

use App\Services\Interfaces\GameServiceInterface;

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
        $shotSessionKey = $gameName . '_shots';

        $shotCount = session($shotSessionKey);

        session()->forget($shotSessionKey);

        return $shotCount;
    }
}
