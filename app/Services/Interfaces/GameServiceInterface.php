<?php

namespace App\Services\Interfaces;

interface GameServiceInterface
{
    public function startGame(array $shipsData, string $gameName): array;

    public function finishGame(string $gameName): int;
}
